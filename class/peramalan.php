<?php
	class peramalan{

		public static function getKelasJumlah($kode_bahan){
	      global $db;
	      $kode_bahan = $db->real_escape_string($kode_bahan);
	      $call = $db->prepare("CALL ambilKelasKeluar(?, @opesan)");
	      $call->bind_param('s', $kode_bahan);
	      $call->execute();
	      if(!$call){
	        return FALSE;
	      }else{
	      	$call->bind_result($kelasJumlah);
	      	$call->fetch();
	        return $kelasJumlah;
	      }
	      $call->close();
	      $db->close();
	    }
		
		public function ramalBahan($kode_bahan){
		  global $db;
	      $kode_bahan = $db->real_escape_string($kode_bahan);
	      $query = "SELECT SUM(jumlah) as jumlah
	                FROM transaksi_bahan 
	                WHERE jenis_transaksi = 'K' AND kode_bahan = '$kode_bahan' AND STR_TO_DATE(DATE_FORMAT(tgl_transaksi,'%Y-%m'),'%Y-%m') 
                                        BETWEEN STR_TO_DATE(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 6 MONTH),'%Y-%m'),'%Y-%m') AND STR_TO_DATE(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 1 MONTH),'%Y-%m'),'%Y-%m')
	                GROUP BY date_format(tgl_transaksi,'%m %Y') 
	                ORDER BY year(tgl_transaksi) ASC, month(tgl_transaksi) ASC";
	      $retrive = $db->query($query);
		  $DA = array();
		  $DF = array(
		   		  array()
			    );
		  $DW = array(0.1,0.2,0.3,0.4,0.5,0.6,0.7,0.8,0.9);
		  $DE2 = array(
				  array()
				 );
		  $SDE = array('0','0','0','0','0','0','0','0','0');
		  
		  for($i = 0; $i <= 8; $i++){
		  	$DW[$i];
		  }
			
		  $bln = 1;
		  $inc = 0;
		  while($hasil = $retrive->fetch_assoc()){
			$DA[$inc] = $hasil['jumlah'];
			for($i = 0; $i <= 8; $i++){
			  if($bln==1){
				$DF[0][$i] = $DA[0]; // Set Nilai Forecast Bulan Awal
			  }else{
				$DF[$inc][$i] = $DA[$inc-1]*$DW[$i]+((1-$DW[$i])*$DF[$inc-1][$i]); // Rumus Peramalan Yang Ada Data Aktualnya
				$DF[$inc][$i] = ROUND($DF[$inc][$i],0,PHP_ROUND_HALF_UP); // Pembulatan Nilai
			  }
			  $Error = $DA[$inc]-($DF[$inc][$i]); // Nilai Error
			  $DE2[$inc][$i] = POW($Error,2); // Nilai Error2
			  $SDE[$i] = $SDE[$i] + $DE2[$inc][$i]; // Sum SDE = Sum Data Error Per Kolom
			}
			$inc++;
			$bln++;
		  }
		  $VNMS = min($SDE); // Ambil Nilai SUM Error2 Dengan SUM Kolom Terkecil VNMS = Variabel Nilai Min Sum
		  for($i = 0; $i <= 8; $i++){
			$DF[$inc][$i] = $DA[$inc-1]*$DW[$i]+((1-$DW[$i])*$DF[$inc-1][$i]); // PERAMALAN TERAKHIR
			$DF[$inc][$i] = ROUND($DF[$inc][$i],0,PHP_ROUND_HALF_UP);
		  }
		  $posisi = array_search($VNMS,$SDE); // Cari Posisi Variabel $VNMS Dari Array SDE
		  $DHF = $DF[$inc][$posisi];
		  $MDA = max($DA); // MDA = MAX DATA AKTUAL
		  $ADA = array_sum($DA)/($inc); // RATA-RATA DATA AKTUAL
		  $ADA = ROUND($ADA,0,PHP_ROUND_HALF_UP);
		  $sefty_stok = ($MDA-$ADA)*1; // SS = (Max Data Aktual Terpilih / ADA) * Lead Time
		  $sefty_stok = ROUND($sefty_stok,0,PHP_ROUND_HALF_UP);
		  $jumlah = $DHF; // Jumlah Peramalan Terpilih
		  $jumlah = ROUND($jumlah,0,PHP_ROUND_HALF_UP);
		  return array($jumlah,$sefty_stok);
		}

		public function tambahPeramalan($kode_bahan,$jumlah,$sefty_stok){
	      global $db;
	      $kode_bahan = $db->real_escape_string($kode_bahan);
	      $jumlah 	  = $db->real_escape_string($jumlah);
	      $sefty_stok = $db->real_escape_string($sefty_stok);
	      $call = $db->prepare("CALL peramalan(?, ?, ?, @opesan)");
	      $call->bind_param('sii', $kode_bahan,$jumlah,$sefty_stok);
	      $call->execute();
	      
	      $select = $db->query("SELECT @opesan");
          $hasil = $select->fetch_assoc();
          $_SESSION['pesan'] = $hasil['@opesan'];
          if(isset($_SESSION['pesan'])){
            return TRUE;
          }else{
            return FALSE;
          }
	      $call->close();
	      $db->close();
	    }

	    public static function getDataPeramalan(){
	      global $db;
	      $query = "SELECT id_peramalan,DATE_FORMAT(tgl_peramalan,'%d/%m/%Y') tgl_peramalan,DATE_FORMAT(tgl_peramalan,'%b %Y') periode, 
	      				   CASE WHEN status_pengadaan = 'B' THEN 'Belum Dilakukan' ELSE 'Sudah Dilakukan' END status_pengadaan
	      			FROM peramalan
	      			WHERE status_pengadaan = 'B'";
	      $hasil = $db->query($query);
	      if($hasil->num_rows == 1){
	        $data = $hasil->fetch_object();
	        return $data;
	      }else{
	        return FALSE;
	      }
	      $hasil->free();
	      $db->close(); 
	    }

	    public function bacaLaporan(){
	      global $db;
	      $stmt = $db->prepare("SELECT p.id_peramalan,DATE_FORMAT(p.tgl_peramalan,'%d-%b-%Y') tgl_peramalan,COUNT(dp.kode_bahan) jumlah_bahan,
	      							CASE WHEN p.status_pengadaan = 'B' THEN 'Belum Dilakukan' ELSE 'Sudah Dilakukan' END status_pengadaan,
	      							DATE_FORMAT(p.terupdate,'%d-%m-%Y | Pukul : %T') terupdate 
	      						FROM peramalan p JOIN detil_peramalan dp
	      						ON(p.id_peramalan = dp.id_peramalan)
                                GROUP BY p.id_peramalan");
	      $stmt->execute();
	      if(!$stmt){
	        return FALSE;
	      }else{
	        return $stmt->get_result();
	      }
	      $stmt->close();
	      $db->close(); 
	    }

	    public static function getDataPeramalanById($id_peramalan){
	      global $db;
	      $id_peramalan = $db->real_escape_string($id_peramalan);
	      $query = "SELECT id_peramalan,DATE_FORMAT(tgl_peramalan,'%d/%m/%Y') tgl_peramalan,DATE_FORMAT(tgl_peramalan,'%b %Y') periode, DATE_FORMAT(SUBDATE(tgl_peramalan, INTERVAL 1 MONTH),'%b %Y') periode_kemarin, 
	      				   CASE WHEN status_pengadaan = 'B' THEN 'Belum Dilakukan' ELSE 'Sudah Dilakukan' END status_pengadaan
	      			FROM peramalan
	      			WHERE id_peramalan = '$id_peramalan'";
	      $hasil = $db->query($query);
	      if($hasil->num_rows == 1){
	        $data = $hasil->fetch_object();
	        return $data;
	      }else{
	        return FALSE;
	      }
	      $hasil->free();
	      $db->close(); 
	    }

	    public function bacaDetilLaporanP($id_peramalan){
	      global $db;
	      $id_peramalan = $db->real_escape_string($id_peramalan);
	      $stmt = $db->prepare("SELECT dp.kode_bahan,bm.nama_bahan,dp.sisa as stok,dp.jumlah,dp.total_pengadaan 
	      						FROM bahan_mentah bm JOIN detil_peramalan dp
	      						ON(bm.kode_bahan = dp.kode_bahan)
	      						WHERE dp.id_peramalan = ?");
	      $stmt->bind_param('i', $id_peramalan);
	      $stmt->execute();
	      if(!$stmt){
	        return FALSE;
	      }else{
	        return $stmt->get_result();
	      }
	      $stmt->close();
	      $db->close(); 
	    }

	    public function bacaDetilPeramalan(){
	      global $db;
	      $stmt = $db->prepare("SELECT bm.kode_bahan,bm.nama_bahan,bm.stok,dp.jumlah,dp.total_pengadaan
	      						FROM bahan_mentah bm JOIN detil_peramalan dp
	      						ON(bm.kode_bahan = dp.kode_bahan)
	      						WHERE dp.id_peramalan = (SELECT id_peramalan
	      												 FROM peramalan
	      												 WHERE status_pengadaan = 'B')");
	      $stmt->execute();
	      if(!$stmt){
	        return FALSE;
	      }else{
	        return $stmt->get_result();
	      }
	      $stmt->close();
	      $db->close(); 
	    }

	    public function ubahStatusPengadaan($id_peramalan){
	      global $db;
	      $id_peramalan = $db->real_escape_string($id_peramalan);
	      $stmt = $db->prepare("UPDATE peramalan SET status_pengadaan = 'S' WHERE id_peramalan = ?");
	      $stmt->bind_param('i', $id_peramalan);
	      $stmt->execute();
	      if($stmt->affected_rows==0){
	        return $_SESSION['pesan'] = 'Data peramalan dengan <b>ID</b> <label class="text-primary">'.$id_peramalan.'</label> tidak ditemukan';
	      }else{
	        return $_SESSION['pesan'] = 'Status data peramalan dengan <b>ID</b> <label class="text-primary">'.$id_peramalan.'</label> telah berhasil diubah';
	      }
	      $stmt->close();
	      $db->close();
	    }

	    public function getHistoryPeramalan(){
	      global $db;
	      $stmt = $db->prepare("
	      						SELECT bm.kode_bahan,bm.nama_bahan,dp.jumlah jumlah_peramalan,((dp.jumlah-bm.stok)+bm.stok_aman) jumlah_pengadaan,DATE_FORMAT(p.tgl_peramalan,'%b %Y') periode
	      						FROM bahan_mentah bm JOIN detil_peramalan dp
	      						ON(bm.kode_bahan = dp.kode_bahan)
                                JOIN peramalan p
                                ON(dp.id_peramalan = p.id_peramalan)
	      						WHERE p.status_pengadaan = 'S'
	      					   ");
	      $stmt->execute();
	      if(!$stmt){
	        return FALSE;
	      }else{
	        return $stmt->get_result();
	      }
	      $stmt->close();
	      $db->close(); 
	    }

	    public static function getRingkasanRamal(){
	      global $db;
	      $query = "SELECT COUNT(*) jml_ramal_bs
	      			FROM peramalan
	      			WHERE status_pengadaan = 'B'";
	      $hasil = $db->query($query);
	      if($hasil->num_rows == 1){
	        $data = $hasil->fetch_object();
	        return $data;
	      }else{
	        return FALSE;
	      }
	      $hasil->free();
	      $db->close();  
	    }

	}
?>
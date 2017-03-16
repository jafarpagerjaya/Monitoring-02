<?php
	class Transaksi{

		public function bacaLaporan(){
	      global $db;
	      $stmt = $db->prepare("SELECT * FROM laporan");
	      $stmt->execute();
	      if(!$stmt){
	        return FALSE;
	      }else{
	        return $stmt->get_result();
	      }
	      $stmt->close();
	      $db->close(); 
	    }
	    /*
	    public function bacaLaporan(){
	      global $db;
	      $query = "SELECT * FROM laporan";
	      $hasil = $db->query($query);
	      if($hasil->num_rows > 0){
	        return $hasil;
	      }else{
	        return false;
	      }
	      $hasil->free();
	      $db->close();
	    }
		*/
	    public static function getDataLaporan($id_laporan){
	      global $db;
	      $id_laporan = $db->real_escape_string($id_laporan);
	      $query = "SELECT * FROM laporan WHERE id_laporan = '$id_laporan'";
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

	    public function bacaDetilLT($id_laporan){
	      global $db;
	      $id_laporan = $db->real_escape_string($id_laporan);
	      $stmt = $db->prepare("SELECT b.kode_bahan,d.nama_bahan,SUM(b.jumlah_m) jumlah_m,SUM(b.jumlah_k) jumlah_k,c.periode
	      						FROM (
		      						  SELECT a.kode_bahan,a.id_laporan,CASE WHEN a.jenis_transaksi = 'M' THEN a.jumlah ELSE 0 END jumlah_m,
	                              	  					  			   CASE WHEN a.jenis_transaksi = 'K' THEN a.jumlah ELSE 0 END jumlah_k
		      						  FROM (
		      							    SELECT kode_bahan,id_laporan,jenis_transaksi,jumlah,sisa
		      							    FROM transaksi_bahan
		      							   ) a
		      						 ) b JOIN laporan c
		      					ON(b.id_laporan = c.id_laporan)
		      					JOIN bahan_mentah d
		      					ON (b.kode_bahan = d.kode_bahan)
		      					WHERE c.id_laporan = ?
		      					GROUP BY b.kode_bahan
		      					ORDER BY b.kode_bahan ASC
	      						");
	      $stmt->bind_param('i', $id_laporan);
	      $stmt->execute();
	      if(!$stmt){
	        return FALSE;
	      }else{
	        return $stmt->get_result();
	      }
	      $stmt->close();
	      $db->close(); 
	    }
	    /*
	    public function bacaDetilLT($id_laporan){
	      global $db;
	      $id_laporan = $db->real_escape_string($id_laporan);
	      $query = "SELECT b.kode_bahan,d.nama_bahan,SUM(b.jumlah_m) jumlah_m,SUM(b.jumlah_k) jumlah_k,c.periode
					FROM (
						  SELECT a.kode_bahan,a.id_laporan,CASE WHEN a.jenis_transaksi = 'M' THEN a.jumlah ELSE 0 END jumlah_m,
                  	  					  			   CASE WHEN a.jenis_transaksi = 'K' THEN a.jumlah ELSE 0 END jumlah_k
						  FROM (
							    SELECT kode_bahan,id_laporan,jenis_transaksi,jumlah,sisa
							    FROM transaksi_bahan
							   ) a
						 ) b JOIN laporan c
					ON(b.id_laporan = c.id_laporan)
					JOIN bahan_mentah d
					ON (b.kode_bahan = d.kode_bahan)
					WHERE c.id_laporan = '$id_laporan'
					GROUP BY b.kode_bahan
					ORDER BY b.kode_bahan ASC";
	      $hasil = $db->query($query);
	      if($hasil->num_rows > 0){
	        return $hasil;
	      }else{
	        return false;
	      }
	      $hasil->free();
	      $db->close();
	    }
	    */
	    public function ubahStatusLT($id_laporan){
	      global $db;
	      $id_laporan = $db->real_escape_string($id_laporan);
	      $stmt = $db->prepare("UPDATE laporan SET status_pengesahan = 'S' WHERE id_laporan = ?");
	      $stmt->bind_param('i', $id_laporan);
	      $stmt->execute();
	      if($stmt->affected_rows==0){
	        return $_SESSION['pesan'] = 'Data laporan transaksi dengan <b>ID</b> <label class="text-primary">'.$id_laporan.'</label> gagal disahkan';
	      }else{
	        return $_SESSION['pesan'] = 'Data laporan transaksi dengan <b>ID</b> <label class="text-primary">'.$id_laporan.'</label> telah berhasil disahkan';
	      }
	      $stmt->close();
	      $db->close(); 
	    }

	    public function setTransaksiMaster($kode_bahan,$jumlahm,$jumlahk,$periode){
	      global $db;
	      /* $kode_bahan = $db->real_escape_string($kode_bahan);
	      $jumlah	  = $db->real_escape_string($jumlah);
	      $periode 	  = $db->real_escape_string($periode);
	      $jenis_tran = $db->real_escape_string($jenis_transaksi);
	      $date 	  = $db->real_escape_string($date);
	      $stmt = $db->prepare("Call transaksi_master(?,?,?,?,?, @opesan)");
	      $stmt->bind_param('sisss', $kode_bahan,$jumlah,$jenis_tran,$date,$periode);
	      $stmt->execute(); */
	      $kode_bahan = $db->real_escape_string($kode_bahan);
	      $jumlahm	  = $db->real_escape_string($jumlahm);
	      $jumlahk	  = $db->real_escape_string($jumlahk);
	      $periode 	  = $db->real_escape_string($periode);
	      $stmt = $db->prepare("Call transaksi_master2(?,?,?,?, @opesan)");
	      $stmt->bind_param('siis', $kode_bahan,$jumlahm,$jumlahk,$periode);
	      $stmt->execute();

	      $select = $db->query("SELECT @opesan");
	      $hasil = $select->fetch_assoc();
	      $_SESSION['pesan'] = $hasil['@opesan'];
	      if(isset($_SESSION['pesan'])){
	        return TRUE;
	      }else{
	        return FALSE;
	      }
	    }

	    public static function setStartDate($kode_bahan){
	      global $db;
	      $kode_bahan = $db->real_escape_string($kode_bahan);
	      $stmt = $db->prepare("SELECT PERIOD_DIFF(DATE_FORMAT(NOW(),'%Y%m'),DATE_FORMAT(tgl_transaksi,'%Y%m'))-1
	      						FROM transaksi_bahan 
	      						WHERE kode_bahan = ? 
	      						ORDER BY tgl_transaksi DESC LIMIT 1;");
	      $stmt->bind_param('s', $kode_bahan);
	      $stmt->execute();
	      if(!$stmt){
	        return FALSE;
	      }else{
	      	$stmt->bind_result($startDate);
        	$stmt->fetch();
	        return $startDate;
	      }
	      $stmt->close();
	      $db->close(); 
	    }

	    public function getHistoryTransaksi(){
	      global $db;
	      $stmt = $db->prepare("SELECT bm.kode_bahan,bm.nama_bahan,tb.jenis_transaksi,SUM(tb.jumlah) jumlah,DATE_FORMAT(tb.tgl_transaksi,'%b %Y') periode
								FROM bahan_mentah bm JOIN transaksi_bahan tb
								ON(bm.kode_bahan = tb.kode_bahan)
								GROUP BY DATE_FORMAT(tb.tgl_transaksi,'%b %Y'),bm.kode_bahan,tb.jenis_transaksi
								ORDER BY 5 DESC, 1 ASC
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
	    /*
	    public function getHistoryTransaksi(){
	      global $db;
	      $query = "SELECT bm.kode_bahan,bm.nama_bahan,tb.jenis_transaksi,SUM(tb.jumlah) jumlah,DATE_FORMAT(tb.tgl_transaksi,'%b %Y') periode
								FROM bahan_mentah bm JOIN transaksi_bahan tb
								ON(bm.kode_bahan = tb.kode_bahan)
								GROUP BY DATE_FORMAT(tb.tgl_transaksi,'%b %Y'),bm.kode_bahan,tb.jenis_transaksi
								ORDER BY 5 DESC, 1 ASC";
	      $hasil = $db->query($query);
	      if($hasil->num_rows > 0){
	        return $hasil;
	      }else{
	        return false;
	      }
	      $hasil->free();
	      $db->close();
	    }
	    */
	    public static function getRingkasanTransaksi(){
	      global $db;
	      $query = "SELECT COUNT(*) jml_tbelum_s
	      						FROM laporan
	      						WHERE status_pengesahan = 'B'";
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
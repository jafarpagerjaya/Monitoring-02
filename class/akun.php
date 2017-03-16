<?php
	class Akun{

		public function getSignin($email,$password){
			global $db;
	        $email 	  = $db->real_escape_string($email);
	        $password = $db->real_escape_string($password);
	        $call = $db->prepare("CALL login(?, ?, @pnip, @pkode_la, @pprivilege, @ppesan)");
		    $call->bind_param('ss', $email, $password);
		    $call->execute();

		    $select = $db->query("SELECT @pnip, @pkode_la, @pprivilege, @ppesan");
		    $hasil = $select->fetch_assoc();
		    $_SESSION['pesan'] = $hasil['@ppesan'];
		    if($hasil['@pprivilege'] == 'TRUE'){
	  	      $_SESSION['nip'] = $hasil['@pnip'];
	  	      $_SESSION['kode_la'] = $hasil['@pkode_la'];
	  	      $_SESSION['privilege'] = $hasil['@pprivilege'];
	          return TRUE;
	  	    }else{
	  	  	  return FALSE;
	  	    }
	      $db->close();
		}

		public function cekPriv(){
	        if (isset($_SESSION['privilege'])){
	            return TRUE;
	        } else {
	            return FALSE;
	        }
    	}

    	public function getSignout($nip){
    		global $db;
      		$query = "UPDATE petugas
        			  SET online = '0'
        			  WHERE nip = $nip";
      		$db->query($query);
  	  		$db->close();
			session_destroy();
			header ('location:../index.php');
		}

		public function daftarkanAkun($nip,$email,$password,$retypepassword){
			global $db;
			$nip 		    = $db->real_escape_string($nip);
	        $email 			= $db->real_escape_string($email);
	        $password 		= $db->real_escape_string($password);
	        $retypepassword = $db->real_escape_string($retypepassword);
	        $call = $db->prepare("CALL pendaftaran_akun(?, ?, ?, ?, @pkode_aktivasi, @ppesan)");
	        $call->bind_param('ssss', $nip,$email,$password,$retypepassword);
	        $call->execute();

	        $select = $db->query("SELECT @pkode_aktivasi, @ppesan");
	        $hasil = $select->fetch_assoc();
	        $_SESSION['kode_aktivasi'] = $hasil['@pkode_aktivasi'];
	        $_SESSION['pesan'] = $hasil['@ppesan'];
	        if(isset($_SESSION['pesan'])){
	          return TRUE;
	        }else{
	          return FALSE;
	        }
	        $db->close();  
		}

		public function aktivasi($kode_aktivasi){
			global $db;
			$kode_aktivasi = $db->real_escape_string($kode_aktivasi);
			$query = "UPDATE petugas
        			  SET aktif = '1', kode_aktivasi = NULL
        			  WHERE kode_aktivasi = $kode_aktivasi";
      		$db->query($query);
      		if($db->affected_rows!=0){
			  return TRUE;
	        }else{
	          return FALSE;
	        }
  	  		$db->close();
		}

		public function dataAkun(){
			global $db;
			$query = "SELECT a.nip, a.email, a.aktif, a.online, DATE_FORMAT(a.terupdate,'%d-%m-%Y %T') as terupdate, b.nama_la 
                	  FROM petugas a JOIN level_akses b 
                	  ON(a.kode_la = b.kode_la)";
	        $hasil = $db->query($query);
	        if($hasil->num_rows > 0){
	          return $hasil;
	        }else{
	          return false;
	        }
	        $hasil->free();
	        $db->close();
		}

		public function setBlokAkun($nip,$pS){
			global $db;
			$nip = $db->real_escape_string($nip);
			$pS = $db->real_escape_string($pS);
	        $stmt = $db->prepare("UPDATE petugas SET password = MD5(?) WHERE nip = ?");
	        $stmt->bind_param('ss', $pS,$nip);
	        $stmt->execute();
	        if($stmt->affected_rows!=0){
			  return $pS;
	        }else{
	          return FALSE;
	        }
	        $stmt->close();
	        $db->close();
		}

		public function setKodeReAktivasi($nip,$kra){
			global $db;
			$nip = $db->real_escape_string($nip);
			$kra = $db->real_escape_string($kra);
	        $stmt = $db->prepare("UPDATE petugas SET kode_aktivasi = ? WHERE nip = ?");
	        $stmt->bind_param('ss', $kra,$nip);
	        $stmt->execute();
	        if($stmt->affected_rows!=0){
			  return TRUE;
	        }else{
	          return FALSE;
	        }
	        $stmt->close();
	        $db->close();
		}

		public function setAktif($nip, $aktiveMode){
			global $db;
			$nip 		= $db->real_escape_string($nip);
	        $aktiveMode	= $db->real_escape_string($aktiveMode);
	        $stmt = $db->prepare("UPDATE petugas SET aktif = ? WHERE nip = ?");
	        $stmt->bind_param('ss', $aktiveMode,$nip);
	        $stmt->execute();
	        if($stmt->affected_rows!=0){
			  return TRUE;
	        }else{
	          return FALSE;
	        }
	        $stmt->close();
	        $db->close();
		}

		public function cekAktifAkun($pk,$aksi){
	      if($pk==$_SESSION['nip']){
	        $_SESSION['pesan'] = 'NIP <label class="text-primary">'.$pk.'</label> Untuk saat ini tidak bisa '.$aksi;
	        return FALSE;
	      }else{
	        $_SESSION['pesan'] = '<label class="text-primary">'.$pk.'</label> Berhasil '.$aksi;
	        return TRUE;
	      }
	    }

	    public static function getRingkasanAkun(){
	      global $db;
	      $query = "SELECT COUNT(b.jml_petugas) jml_petugas,SUM(b.jml_akun_ak) jml_akun_ak,SUM(b.jml_akun_ba) jml_akun_ba,SUM(b.jml_akun_ab) jml_akun_ab
	      			FROM (
	      				  SELECT a.nip jml_petugas, CASE WHEN a.aktif = '1' THEN 1 ELSE 0 END jml_akun_ak,
	      				  							CASE WHEN a.aktif = '0' THEN 1 ELSE 0 END jml_akun_ba,
	      				  							CASE WHEN a.aktif = '' THEN 1 ELSE 0 END jml_akun_ab
		      			  FROM (
			      				SELECT nip, aktif 
			      				FROM petugas
			      			   ) a
			      		  ) b";
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

	    public function cekEmail($email){
	      global $db;
		  $email = $db->real_escape_string($email);
          $stmt = $db->prepare("SELECT COUNT(*) nilai FROM petugas WHERE email = ?");
          $stmt->bind_param('s', $email);
          $stmt->execute();
          $stmt->bind_result($nilai);
	      $stmt->fetch();
          if($nilai == 1){
		    return TRUE;
          }else{
          	$_SESSION['pesan'] = 'Data akun dengan email <label class="text-primary">'.$email.'</label> tidak dapat ditemukan';
            return FALSE;
          }
          $stmt->close();
          $db->close();
	    }

	    public function ubahPasswordSementara($email,$password){
	      global $db;
		  $email 	= $db->real_escape_string($email);
		  $password = $db->real_escape_string($password);
          $stmt = $db->prepare("UPDATE petugas SET password = MD5(?) WHERE email = ?");
          $stmt->bind_param('ss', $password,$email);
          $stmt->execute();
          if($stmt->affected_rows!=0){
		    return TRUE;
          }else{
          	$_SESSION['pesan'] = 'Permohonan lupa password akun dengan email <label class="text-primary">'.$email.'</label> gagal dilakukan';
            return FALSE;
          }
          
          $stmt->close();
          $db->close();
	    }

	}
?>
<?php
	class Jabatan{

		public function getJabatan(){
	      global $db;
	      $query = "SELECT kode_la, nama_la FROM level_akses";
	      $hasil = $db->query($query);
	      if($hasil->num_rows > 0){
	        return $hasil;
	      }else{
	        return false;
	      }
	      $db->close();
	    }

	}
?>
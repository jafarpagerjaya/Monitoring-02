<?php
class Data{
	public function backupDatabase($jenis_backup,$ket_backup){
		global $db;
		$jenis_backup = $db->real_escape_string($jenis_backup);
		$ket_backup   = $db->real_escape_string($ket_backup);
  	  	$backup_file_name = $ket_backup.'_'.date('d-m-Y-H-i-s').'.sql';
  	  	header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
      	header('Content-Disposition: attachment; filename='.$backup_file_name);
      	if($jenis_backup=='2'){
      	  $cmd = "C:/xampp/mysql/bin/mysqldump --user=root --password= --host=localhost --routines --triggers fiestaparfum_kp";
      	  passthru( $cmd );
      	  exit(0);
      	}else{
      	  $cmd = "C:/xampp/mysql/bin/mysqldump --user=root --password= --host=localhost fiestaparfum_kp";
      	  passthru( $cmd );
      	  exit(0);
      	}
	}

	public function restoreDatabase($file_name){
		global $db;
		$cmd = "C:/xampp/mysql/bin/mysql --user=root --password= --host=localhost fiestaparfum_kp < " .$file_name;
  	    exec( $cmd );
  	    unlink($file_name);
	}

	public function backupData($table){
		global $db;
		$table = $db->real_escape_string($table);
		$result = "TRUNCATE TABLE ".$table.";";
		$querySD = $db->query("SELECT * FROM ".$table);
		$jml_baris = $querySD->num_rows;
		$jml_kolom = $querySD->field_count;
		if($querySD){
			$result .= "INSERT INTO ".$table." VALUES";
												$i = 1;
												while($hasil = $querySD->fetch_array()){
													$result .= "(";
													for($j = 0; $j < $jml_kolom; $j++){
														$hasil[$j] = addslashes($hasil[$j]);
														$hasil[$j] = ereg_replace("\n", "\n\n", $hasil[$j]);
														if(!empty($hasil[$j])){
															$result .= "'".$hasil[$j]."'";
														}else{
															$result .= "NULL";
														}
														if($j < $jml_kolom-1){
															$result .= ",";
														}
													}
													if($i < $jml_baris){
														$result .= "),";
													}else{
														$result .= ");";
													}	
													$i++;
												}
		}else{
			$result = "Error";
		}
		return $result;
	}

	public function restoreData(){

	}

	public function backupDataTable($table){
		global $db;
		$table = $db->real_escape_string($table);
		$result = "DROP TABLE IF EXISTS ".$table.";";
		$queryST = $db->query("SHOW CREATE TABLE ".$table);
		$hasil = $queryST->fetch_array();
		$result .= $hasil[1].";";
		$querySD = $db->query("SELECT * FROM ".$table);
		$jml_baris = $querySD->num_rows;
		$jml_kolom = $querySD->field_count;
		if($querySD){
			$result .= "INSERT INTO ".$table." VALUES";
												$i = 1;
												while($hasil = $querySD->fetch_array()){
													$result .= "(";
													for($j = 0; $j < $jml_kolom; $j++){
														$hasil[$j] = addslashes($hasil[$j]);
														$hasil[$j] = ereg_replace("\n", "\n\n", $hasil[$j]);
														if(!empty($hasil[$j])){
															$result .= "'".$hasil[$j]."'";
														}else{
															$result .= "NULL";
														}
														if($j < $jml_kolom-1){
															$result .= ",";
														}
													}
													if($i < $jml_baris){
														$result .= "),";
													}else{
														$result .= ");";
													}	
													$i++;
												}
		}else{
			$result = "Error";
		}
		return $result;
	}

	public function showTables($l1,$l2){
		global $db;
		$l1 = $db->real_escape_string($l1);
		$l2 = $db->real_escape_string($l2);
		$stmt = $db->prepare("SELECT table_name FROM information_schema.tables WHERE table_schema = 'fiestaparfum_kp' LIMIT ?,?;");
		$stmt->bind_param('ii',$l1,$l2);
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
	public function showTables($l1,$l2){
		global $db;
		$l1 = $db->real_escape_string($l1);
		$l2 = $db->real_escape_string($l2);
		$query = "SELECT table_name FROM information_schema.tables WHERE table_schema = 'fiestaparfum_kp' LIMIT '$l1','$l2'";
		$hasil = $db->query($query);
		if($hasil->num_rows > 0){
			return $hasil;
		}else{
			return $false;
		}
		$stmt->close();
		$db->close();
	}
	*/
}
?>
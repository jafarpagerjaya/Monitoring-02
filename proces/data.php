<?php
  session_start(); // <-- Harus ada kecuali dlm class
  if(isset($_POST['backup'])){
    include 'koneksi.php';
    include '../class/data.php';
    if((isset($_POST['all-table'])) && (isset($_POST['jenis_backup']))){
      $jenis_backup = $_POST['jenis_backup'];
      if(($jenis_backup=='2') OR ($jenis_backup=='1')){
        echo 'DROP DATABASE IF EXISTS fiestaparfum_kp;CREATE DATABASE fiestaparfum_kp;USE fiestaparfum_kp;';
        if($jenis_backup=='2'){
          $ket_backup = 'Full_Backup';
        }else{
          $ket_backup = 'Data_&_Struktur_Backup';
        }
        $oBA = Data::backupDatabase($jenis_backup,$ket_backup);
      }else{
        if(isset($_POST['table'])){
          $tables = array();
          foreach($_POST['table'] as $table){
            array_push($tables, $table);
            $ket_backup = 'Data';
            echo $oBDT = Data::backupData($table);
            $backup_file_name = $ket_backup.'_'.implode('_', $tables).'_'.date('d-m-Y');
            header("Content-Disposition: attachment; filename= ".$backup_file_name.".sql");
            header("Content-type: application/download");
          }
        }else{
          $_SESSION['pesan'] = 'Tabel tidak ditemukan';
          header('location:../pages/admin/dustboard.php');
        }
      }
    }else if((!isset($_POST['all-table'])) && (isset($_POST['jenis_backup']))){
      if(isset($_POST['table'])){
        $tables = array();
        $jenis_backup = $_POST['jenis_backup'];
        if(($jenis_backup=='1') OR ($jenis_backup=='0')){
        	foreach($_POST['table'] as $table){
            array_push($tables, $table);
            if($jenis_backup=='1'){
              $ket_backup = 'Data_Table';
              echo $oBDT = Data::backupDataTable($table);
            }else{
              $ket_backup = 'Data';
              echo $oBDT = Data::backupData($table);
            }
            $backup_file_name = 'Backup_'.$ket_backup.'_'.implode('_', $tables).'_'.date('d-m-Y');
            header("Content-Disposition: attachment; filename= ".$backup_file_name.".sql");
            header("Content-type: application/download");
          }
        }
      }else{
        $_SESSION['pesan'] = 'Tabel tidak ditemukan';
        header('location:../pages/admin/dustboard.php');
      }
    }
  }else if($_FILES['file_restore']){
    include 'koneksi.php';
    include '../class/data.php';
    $filename = $_FILES["file_restore"]["name"];
    if(move_uploaded_file ($_FILES["file_restore"]["tmp_name"],$filename)){
       $oRDB = Data::restoreDatabase($filename);
       $output = array('uploaded' => 'OK' );
    }else{
       $output = array('uploaded' => 'ERROR' );
    }
    echo json_encode($output);
  }else{
  	header('location:../index.php');
  }
?>
<?php
  session_start(); // <-- Harus ada kecuali dlm class
  require 'lib.php';
  require 'koneksi.php';
  require '../class/pegawai.php';
  if(isset($_POST['simpan'])){
  	$nip 		       = $_POST['nip'];
    $nama_depan    = ucfirst(strtolower(pegreplaceWSpace($_POST['nama_depan'])));
    $nama_belakang = ucfirst(strtolower(pegreplaceWSpace($_POST['nama_belakang'])));
    $email 		     = strtolower($_POST['email']);
    $kontak 	     = pegreplaceKontak($_POST['kontak']);
    $kode_la       = $_POST['kode_la'];
    $otp = new Pegawai();
    $otp->tambahPegawai($nip,$nama_depan,$nama_belakang,$email,$kontak,$kode_la);
    header('location:../pages/manajer/pegawai.php');
  }else if(isset($_POST['ubah'])){
  	$oup = new Pegawai();
  	if($oup->cekUbahPegawai($_POST['nip'],$_POST['kode_la'])==FALSE){
  	  header('location:../pages/manajer/pegawai.php');
  	}else{
  	  $nip 		       = $_POST['nip'];
      $nama_depan    = pegreplaceWSpace($_POST['nama_depan']);
      $nama_belakang = pegreplaceWSpace($_POST['nama_belakang']);
      $email 		     = strtolower($_POST['email']);
      $kontak 	     = pegreplaceKontak($_POST['kontak']);
      $kode_la       = $_POST['kode_la'];
  	  $oup->ubahPegawai($nama_depan,$nama_belakang,$email,$kontak,$kode_la,$nip);
  	  header('location:../pages/manajer/pegawai.php');
  	}
  }else if(isset($_GET['hapus'])){
  	$ohp = new Pegawai();
  	if($ohp->cekHapusPegawai($_GET['hapus'])==FALSE){
  	  header('location:../pages/manajer/pegawai.php');
  	}else{
  	  $ohp->hapusPegawai($_GET['hapus']);
  	  header('location:../pages/manajer/pegawai.php');
  	}
  }else{
  	$_SESSION['pesan'] = 'Salah masuk kamar XD';
    header('location:../index.php');
  }
?>
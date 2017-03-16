<?php
  session_start();
  require 'lib.php';
  require 'koneksi.php';
  require '../class/peramalan.php';
  if(isset($_GET['pengadaan'])){
    $iup = new Peramalan();
    $iup->ubahStatusPengadaan($_GET['pengadaan']);
    header('location:../pages/produksi/bahanbaku.php');
  }else if(isset($_GET['id_peramalan'])){
    $id_peramalan = $_GET['id_peramalan'];
    $ibl = new Peramalan();
    $data = $ibl->bacaDetilLaporanP($_GET['id_peramalan']);
    if($data){
      $_SESSION['id_peramalan'] = $id_peramalan;
    }else{
      $_SESSION['pesan'] = 'Data peramalan dengan ID '.$id_peramalan.' tidak ditemukan';
    }
    header('location:../pages/manajer/lap-peramalan.php');
  }else if(isset($_GET['hapus_lp'])){
    unset($_SESSION['id_peramalan']);
    header('location:../pages/manajer/lap-peramalan.php');
  }else{
  	$_SESSION['pesan'] = 'Salah masuk kamar XD';
    header('location:../index.php');
  }
?>
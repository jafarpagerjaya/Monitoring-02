<?php
  session_start();
  require 'koneksi.php';
  require '../class/transaksi.php';
  if(isset($_POST['transaksi_master'])){
    require 'lib.php';
    $kode_bahan      = inputFilter($_POST['kode_bahan']);
    $jumlahm         = inputFilter(pegreplaceRibuan($_POST['jumlahm']));
    $jumlahk         = inputFilter(pegreplaceRibuan($_POST['jumlahk']));
    $periode         = inputFilter($_POST['periode']);
    $ittm = new Transaksi();
    $ittm->setTransaksiMaster($kode_bahan,$jumlahm,$jumlahk,$periode);
    header('location:../pages/admin/transaksi-m.php');
  }else if((isset($_GET['ubahSPLT'])) AND ($_GET['id_laporan'])){
    $id_laporan = $_GET['id_laporan'];
    $uslt = new Transaksi();
    $uslt->ubahStatusLT($id_laporan);
    header('location:../pages/manajer/dl-transaksi.php');
  }else{
    $_SESSION['pesan'] = 'Salah masuk kamar XD';
    header('location:../index.php');
  }
?>
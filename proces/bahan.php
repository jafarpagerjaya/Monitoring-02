<?php
  session_start();
  require 'lib.php';
  require 'koneksi.php';
  require '../class/bahan.php';
  if(isset($_POST['simpan'])){
  	$kode_bahan = strtoupper(pegreplaceWSpace($_POST['kode_bahan']));
    $nama_bahan = ucfirst(pegreplaceWSpace($_POST['nama_bahan']));
    $harga_pl   = pegreplaceRibuanRp($_POST['harga_pl']);
    $itb = new Bahan();
    $itb->tambahBahan($kode_bahan,$nama_bahan,$harga_pl);
    header('location:../pages/produksi/bahanbaku.php');
  }else if(isset($_POST['ubah'])){
  	$iub = new Bahan();
	  $kode_bahan = $_POST['kode_bahan'];
    $nama_bahan = ucfirst(pegreplaceWSpace($_POST['nama_bahan']));
    $harga_pl   = pegreplaceRibuan($_POST['harga_pl']);
	  $iub->ubahBahan($kode_bahan,$nama_bahan,$harga_pl);
	  header('location:../pages/produksi/bahanbaku.php');
  }else if(isset($_GET['hapus'])){
  	$ihb = new Bahan();
	  $ihb->hapusBahan($_GET['hapus']);
	  header('location:../pages/produksi/bahanbaku.php');
  }else if(isset($_POST['ramal'])){
    require '../class/peramalan.php';
    $kode_bahan = strtoupper(pegreplaceWSpace($_POST['kode_bahan']));
    $irb        = new Peramalan();
    /*
    if(!isset($_POST['ramal_semua'])){
      $gol_keluar = $irb->getKelasJumlah($kode_bahan);
      $jumlah     = $irb->ramalBahan($kode_bahan,$gol_keluar)[0];
      $safty_stok = $irb->ramalBahan($kode_bahan,$gol_keluar)[1];
      $irb->tambahPeramalan($kode_bahan,$jumlah,$safty_stok);
      header('location:../pages/produksi/bahanbaku.php');
    }else{
      do{
        $kode_bahan = Bahan::getKodeBahan();
        $_SESSION['getKodeBahan'] = $kode_bahan;
        $gol_keluar = $irb->getKelasJumlah($kode_bahan);
        $jumlah     = $irb->ramalBahan($kode_bahan,$gol_keluar)[0];
        $safty_stok = $irb->ramalBahan($kode_bahan,$gol_keluar)[1];
        $irb->tambahPeramalan($kode_bahan,$jumlah,$safty_stok);
      }while($_SESSION['getKodeBahan']!=FALSE);
      unset($_SESSION['getKodeBahan']);
      $_SESSION['pesan'] = 'Seluruh bahan berhasil diramalkan';
      header('location:../pages/produksi/bahanbaku.php');
    }
    */
    
    if(!isset($_POST['ramal_semua'])){
      $jumlah     = $irb->ramalBahan($kode_bahan)[0];
      $safty_stok = $irb->ramalBahan($kode_bahan)[1];
      $irb->tambahPeramalan($kode_bahan,$jumlah,$safty_stok);
      header('location:../pages/produksi/bahanbaku.php');
    }else{
      do{
        $kode_bahan = Bahan::getKodeBahan();
        $_SESSION['getKodeBahan'] = $kode_bahan;
        if(isset($_SESSION['getKodeBahan'])){
          $jumlah     = $irb->ramalBahan($kode_bahan)[0];
          $safty_stok = $irb->ramalBahan($kode_bahan)[1];
          $irb->tambahPeramalan($kode_bahan,$jumlah,$safty_stok);
        }
      }while($_SESSION['getKodeBahan']!=FALSE);
      unset($_SESSION['getKodeBahan']);
      $_SESSION['pesan'] = 'Seluruh bahan berhasil diramalkan';
      header('location:../pages/produksi/bahanbaku.php');
    }
  }else if(isset($_POST['trans_masuk'])){
    $kode_bahan = $_POST['kode_bahan'];
    $jumlah     = pegreplaceRibuan($_POST['jumlah']);
    $itm = new Bahan();
    $itm->tambahTransaksiMasuk($kode_bahan,$jumlah);
    header('location:../pages/produksi/transaksibahan.php');
  }else if(isset($_POST['trans_keluar'])){
    $kode_bahan = $_POST['kode_bahan'];
    $jumlah     = pegreplaceRibuan($_POST['jumlah']);
    $itm = new Bahan();
    $itm->tambahTransaksiKeluar($kode_bahan,$jumlah);
    header('location:../pages/produksi/transaksibahan.php');
  }else if(isset($_POST['bln'])){
    $bln = $_POST['bln'];
    $_SESSION['bln'] = $bln;
    header('location:../pages/produksi/transaksibahan.php');
  }else if(isset($_GET['hapus_lt'])){
    unset($_SESSION['bln']);
    header('location:../pages/produksi/transaksibahan.php');
  }else if((isset($_GET['simpan_lt'])) AND (isset($_GET['bln']))){
    $bln = $_GET['bln'];
    $ilt = new Bahan();
    $ilt->simpanLaporanTB($bln);
    unset($_SESSION['bln']);
    header('location:../pages/produksi/transaksibahan.php');
  }else if((isset($_POST['bhn_lain'])) AND (isset($_POST['kode_bahan']))){
    $kode_bahan = $_POST['kode_bahan'];
    $_SESSION['kode_bahan'] = $kode_bahan;
    header('location:../pages/produksi/dastboard.php');
  }else{
  	$_SESSION['pesan'] = 'Salah masuk kamar XD';
    header('location:../index.php');
  }
?>
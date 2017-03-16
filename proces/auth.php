<?php
  session_start(); // <-- Harus ada kecuali dlm class
  if(isset($_POST['signin'])){
    include 'koneksi.php';
    include '../class/akun.php';
    $akun = new Akun();
    $akun->getSignin($_POST['email'],$_POST['password']);
    header('location:../index.php');
  }else if(isset($_GET['signout'])){
    include 'koneksi.php';
    include '../class/akun.php';
    $akun = new Akun();
    $akun->getSignout($_SESSION['nip']);
  }else if(isset($_POST['register'])){
    include 'koneksi.php';
    include '../class/akun.php';
    include 'lib.php';
    $akun = new Akun();
    $akun->daftarkanAkun($_POST['nip'],strtolower($_POST['email']),$_POST['password'],$_POST['retypepassword']);
    if($_SESSION['pesan']=='Akun anda berhasil dibuat. Link aktivasi akun telah dikirim ke email anda, lanjutkan aktivasi agar akun dapat digunakan'){
      $_SESSION['statusKirimEmailAktivasiAkun'] = kirimEmailAktivasiAkun($_POST['email'],$_SESSION['kode_aktivasi']);
      unset($_SESSION['kode_aktivasi']);
    }
    header('location:../pages/view/register.php');
  }else if(isset($_GET['kode_aktivasi'])){
    include 'koneksi.php';
    include '../class/akun.php';
    $akun = new Akun();
    $aktif = $akun->aktivasi($_GET['kode_aktivasi']);
    if($aktif==TRUE){
	    $_SESSION['pesan'] = 'Akun telah resmi diaktifkan';
	  }else{
	    $_SESSION['pesan'] = 'Akun gagal diaktifkan, kode belum cocok';
	  }
	  header ('location:../index.php');
  }else if((isset($_GET['aksi'])) && (isset($_GET['nip'])) && (isset($_GET['email']))){
    include 'koneksi.php';
    include '../class/akun.php';
    include 'lib.php';
    $akun = new Akun();
    if($akun->cekAktifAkun($_GET['nip'],setPesanAktive($_GET['aksi']))==FALSE){ // cekAktifAkun = cek nip lg on adalah diri sendiri == [FALSE]
      header ('location:../pages/view/akun.php');
    }else{ // nip lg on/off bukan diri sendiri == [TRUE]
      // $_GET['aksi'] == setAksiAkun()
      // parsing setAksiAkun() dilakukan di view/akun.php
      // setAksiAkun(NULL) == 'membuka'
      // setAksiAkun(1) == 'menutup'
      // setAksiAkun(0) == 'mengaktifkan'
      if(setIdAktive($_GET['aksi'])=='0'){ // setIdAktive(membuka) == 0
        $pSementara = randSting();
        $akun->setBlokAkun($_GET['nip'],$pSementara); // set Pass sementara saat terblock
        $power = $akun->setAktif($_GET['nip'],setIdAktive($_GET['aksi']));
        $kReAktivasi = strrev($_GET['nip']).''.$_GET['nip'];
        $akun->setKodeReAktivasi($_GET['nip'],$kReAktivasi);
        $hasil = kirimEmailReAktivasiAkun($_GET['email'],$pSementara,$kReAktivasi);
        // $_SESSION['kirimEmailReAktivasiAkun'] = $hasil.' Pass >> '.$pSementara.' KodeReAk >> '.$kReAktivasi;
      }else{
        $power = $akun->setAktif($_GET['nip'],setIdAktive($_GET['aksi'])); // setIdAktive(menutup) == NULL OR setIdAktive(mengaktifkan) == 1
      }
      if($power==TRUE){
          $_SESSION['pesan'] = 'Akun NIP '.$_GET['nip'].' telah resmi di'.setPesanAktive($_GET['aksi']);
        }else{
          $_SESSION['pesan'] = 'Akun NIP '.$_GET['nip'].' gagal di'.setPesanAktive($_GET['aksi']);
      }
      header ('location:../pages/view/akun.php');
    }
  }else if((isset($_POST['lupa_password'])) && (isset($_POST['email']))){
    include 'koneksi.php';
    include '../class/akun.php';
    include 'lib.php';
    $email = $_POST['email'];
    $ilp = new Akun();
    $hasil = $ilp->cekEmail($email);
    if($hasil==FALSE){
      header ('location:../index.php');
    }else{
      $pSementara = randSting();
      if(($ilp->ubahPasswordSementara($email,$pSementara))==TRUE){
        $hasil = kirimEmailLupaPassword($email,$pSementara);
        // $_SESSION['kirimEmailLupaPassword'] = $hasil. ' Pass >> '.$pSementara;
        $_SESSION['pesan'] = 'Password sementara telah dikirim ke email anda, silahkan cek email.';
        header ('location:../index.php');
      }else{
        header ('location:../index.php');
      }
    }
  }else{
    $_SESSION['pesan'] = 'Salah masuk kamar XD';
    header('location:../index.php');
  }
?>
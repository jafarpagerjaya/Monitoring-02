<?php
/* 
	Sistem Monitoring Persediaan Bahan Baku Parfum di CV.Fiesta Parfum
	Jafar Pager Jaya www.facebook.com/jafar.pagerjaya
	Copyright 2016
*/
	session_start();
	require_once 'proces/koneksi.php';
	require_once 'class/akun.php';

	// inisiasi akun
	$akun = new Akun();
	$akun->cekPriv();

	if($akun->cekPriv() == TRUE){
		header('location:proces/system-priv.php');
	}else{
		header('location:pages/view/signin.php');
	}
?>
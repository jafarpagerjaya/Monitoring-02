<?php
	session_start();
	if((isset($_SESSION['privilege'])) AND ($_SESSION['kode_la']=='PRD')){
      header('location:../pages/produksi/dastboard.php');
    }else if((isset($_SESSION['privilege'])) AND ($_SESSION['kode_la']=='MGR')){
      header('location:../pages/manajer/dashboard.php');
    }else if((isset($_SESSION['privilege'])) AND ($_SESSION['kode_la']=='ADM')){
      header('location:../pages/admin/dashboard.php');
    // }else if((isset($_SESSION['privilage'])) AND ($_SESSION['kode_la']=='SUP')){
    //   header('location:../pages/suplaier/dashboard.php');
    }else{
      $_SESSION['pesan'] = 'Salah masuk kamar XD';
      header('location:../index.php');
    }
?>
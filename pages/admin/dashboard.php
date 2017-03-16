<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='ADM')){
require '../../class/pegawai.php';
require '../../class/akun.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$dashboard = 'active';
$ringkasAkun = Akun::getRingkasanAkun();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- fileinput -->
    <link href="../../asset/plugins/fileinput/fileinput.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link href="../../asset/dist/css/AdminLTE.min.css" rel="stylesheet">
    <!-- AdminLTE Skins -->
    <link href="../../asset/dist/css/skins/skin-purple.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../asset/plugins/iCheck/square/blue.css" rel="stylesheet">
    <!-- Override style -->
    <link href="../../asset/dist/css/main.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  |---------------------------------------------------------|
  | SKINS         | skin-purple                             |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="skin-purple sidebar-mini">
    <div class="wrapper">
    <?php include_once '../header.php'; ?>
    <?php include_once '../main-sidebar.php'; ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Halaman<small>Dashboard</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

    	  <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $ringkasAkun->jml_petugas; ?></h3>
                  <p>Jumlah Akun</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-stalker"></i>
                </div>
                <a href="../view/akun.php" class="small-box-footer">Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $ringkasAkun->jml_akun_ak; ?></h3>
                  <p>Jumlah Akun Aktif</p>
                </div>
                <div class="icon">
                  <i class="ion ion-checkmark"></i>
                </div>
                <a href="../view/akun.php" class="small-box-footer">Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $ringkasAkun->jml_akun_ba; ?></h3>
                  <p>Jumlah Akun Belum Aktif</p>
                </div>
                <div class="icon">
                  <i class="ion ion-android-warning"></i>
                </div>
                <a href="../view/akun.php" class="small-box-footer">Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $ringkasAkun->jml_akun_ab; ?></h3>
                  <p>Jumlah Akun Terblok</p>
                </div>
                <div class="icon">
                  <i class="ion ion-close"></i>
                </div>
                <a href="../view/akun.php" class="small-box-footer">Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

          <div class="row">
          	<div class="col-xs-6">
          	  <div class="nav-tabs-custom">
          	  	<ul class="nav nav-tabs">
          	  	  <li class="active"><a href="#tab_b" data-toggle="tab">Backup Data</a></li>
          	  	  <li><a href="#tab_r" data-toggle="tab">Restore Data</a></li>
          	  	</ul>
          	  	<div class="tab-content">
          	  	  <div class="tab-pane active" id="tab_b">
                    <form action="../../proces/data.php" method="POST">
                      <div class="row">
            	  	      <div class="col-md-3">
                          <b>Pilih Backup :</b> 
            	  	  	  </div>
                        <div class="col-md-9">
                          <div class="form-group no-margin">
                            <label>
                              <input type="radio" id="radio0" name="jenis_backup" value="0" class="minimal" checked>
                              Data Saja
                            </label>
                            <label>
                              <input type="radio" id="radio1" name="jenis_backup" value="1" class="minimal">
                              Data dan Struktur
                            </label>
                            <label>
                              <input type="radio" id="radio2" name="jenis_backup" value="2" class="minimal">
                              Full Backup
                            </label>
                          </div>
                        </div>
                      </div>
          	  	  		<div class="row">
          	  	  			<div class="col-md-6">
		         							<div class="checkbox icheck">
						                <label>
						                  <input type="checkbox" name="all-table" id="checked-all"> Seluruh Tabel
						                </label>
						              </div>
						              <?php 
						              	require '../../class/data.php';
						              	$oDB = new Data();
						              	$rowSTL03 = $oDB->showTables(0,3);
                            $i = 0;
						                while($hasil = $rowSTL03->fetch_assoc()){
                            $c_num = 'cn'.$i;
						              ?>
						              	<div class="checkbox icheck">
							                <label>
							                  <input type="checkbox" id="<?php echo $c_num; ?>" name="table[]" class="check" value="<?php echo $hasil['table_name']; ?>"> <?php echo $hasil['table_name']; ?>
							                </label>
							              </div>
						              <?php  
                            $i++;
						                }
                            $rowSTL03->free();
						              ?>
						            </div>
						            <div class="col-md-6">
						              <?php
						              	$rowSTL34 = $oDB->showTables(3,4);
						                while($hasil = $rowSTL34->fetch_assoc()){
                            $c_num = 'cn'.$i;
						              ?>
						              	<div class="checkbox icheck">
							                <label>
							                  <input type="checkbox" id="<?php echo $c_num; ?>" name="table[]" class="check" value="<?php echo $hasil['table_name']; ?>"> <?php echo $hasil['table_name']; ?>
							                </label>
							              </div>
						              <?php  
                            $i++;
						                }
                            $rowSTL34->free();
						              ?>
						            </div>
						            <div class="col-md-6">
						            	<p>*Pilihlah tabel yang hendak di backup</p>	
						            </div>
						            <div class="col-md-6">
						            	<div class="form-group">
						            	  <button name="backup" type="submit" class="btn btn-success btn-flat pull-right"><i class="glyphicon glyphicon-export"></i> Proses Backup</button>
						            	</div>
						            </div>
					            </div>
          	  	  	</form>
          	  	  </div>
          	  	  <div class="tab-pane" id="tab_r">
                    <div class="row">
                      <div class="col-md-12">
                        <b>Pilih File Restore :</b>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <form enctype="multipart/form-data">
                          <div class="form-group">
                           <input id="file" class="file-loading" name="file_restore" type="file" multiple>
                          </div>
                        </form>
                      </div>
                    </div>
          	  	  </div>
          	  	</div>
          	  </div>
          	</div>
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    <?php include_once '../footer.php'; ?>
    </div><!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->

  <!-- jQuery 2.1.4 -->
  <script src="../../asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="../../asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- AdminLTE App -->
  <script src="../../asset/dist/js/app.min.js" type="text/javascript"></script>
  <!-- iCheck -->
  <script src="../../asset/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
  <!-- fileinput -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.4/js/fileinput.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.3.4/js/locales/id.min.js" type="text/javascript"></script>

  <script type="text/javascript">
  	$(function () {
		  $('input').iCheck({
		    checkboxClass: 'icheckbox_square-blue',
		    radioClass: 'iradio_square-blue',
		    increaseArea: '20%' // optional
		  });
      $('#radio2').on('ifChecked', function(event) {
        $('#checked-all').iCheck('check');
        triggeredByChild = false;
      });
      $('#checked-all').on('ifUnchecked', function(event) {
        if($('#radio0').is(':checked')){
          $('#radio1').iCheck('uncheck');
          $('#radio0').iCheck('check');
        }else{
          $('#radio2').iCheck('uncheck');
          $('#radio1').iCheck('check');
        }
      });
		  $('#checked-all').on('ifChecked', function(event) {
				$('.check').iCheck('check');
				triggeredByChild = false;
			});
			$('#checked-all').on('ifUnchecked', function(event) {
				if (!triggeredByChild) {
        $('.check').iCheck('uncheck');
		    }
		    triggeredByChild = false;
			});
			// Removed the checked state from "All" if any checkbox is unchecked
			$('.check').on('ifUnchecked', function (event) {
			    triggeredByChild = true;
			    $('#checked-all').iCheck('uncheck');
			});
			$('.check').on('ifChecked', function (event) {
			    if ($('.check').filter(':checked').length == $('.check').length) {
			        $('#checked-all').iCheck('check');
			    }
			});
      // Spesific checkbox is checked
      $('#cn2').on('ifChecked', function(event) {
        $('#cn6').iCheck('check');
        triggeredByChild = false;
      });
      $('#cn0').on('ifChecked', function(event) {
        $('#cn1').iCheck('check');
        $('#cn6').iCheck('check');
        triggeredByChild = false;
      });
      $('#cn1').on('ifChecked', function(event) {
        $('#cn4').iCheck('check');
        triggeredByChild = false;
      });
      // Removed the checked state from spesific checkbox is unchecked
      $('#cn2').on('ifUnchecked', function (event) {
          triggeredByChild = true;
          $('#cn6').iCheck('uncheck');
      });
      $('#cn0').on('ifUnchecked', function (event) {
          triggeredByChild = true;
          $('#cn1').iCheck('uncheck');
          $('#cn6').iCheck('uncheck');
      });
      $('#cn4').on('ifUnchecked', function (event) {
          triggeredByChild = true;
          $('#cn1').iCheck('uncheck');
      });

			$('button[type="submit"]').on('click', function() {
			  $cbx_group = $("input:checkbox[name='table[]']");
				$cbx_group.prop('required', true);
				if($cbx_group.is(":checked")){
				  $cbx_group.prop('required', false);
				}
			});
		});
    $(document).ready(function(){
      $('#file').fileinput({
        language: 'id',
        uploadAsync: false,
        uploadUrl: 'http://localhost:81/Monitoring/proces/data.php',
        allowedFileExtensions : ['sql'],
        autoReplace: true,
        maxFileCount: 1,
        showBrowse: false,
        browseOnZoneClick: true
      });
     });
  </script>

  <?php
    if(isset($_SESSION['pesan'])){
  ?>
  <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-sm">
        
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pesan</h4>
          </div>
          <div class="modal-body">
            <?php
                echo $_SESSION['pesan'];
                unset($_SESSION['pesan']);
            ?>
          </div>
        </div>
        
      </div>
    </div>
  <?php
    }
  ?>
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
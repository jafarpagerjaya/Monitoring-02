<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='MGR')){
require '../../class/pegawai.php';
require '../../class/peramalan.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$tree_his = 'active';
$his_peramalan = $tree_his;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - History Peramalan</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link href="../../asset/dist/css/AdminLTE.min.css" rel="stylesheet">
    <!-- AdminLTE Skins -->
    <link href="../../asset/dist/css/skins/skin-purple.min.css" rel="stylesheet">
    <!-- Override style -->
    <link href="../../asset/dist/css/main.css" rel="stylesheet">
    <!-- DATA TABES -->
    <link href="../../asset/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
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
          <h1>Halaman<small>H-Peramalan</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php $_SERVER['PHP_SELF']; ?>"><i class="fa fa-clock-o"></i> Kelola History</a></li>
            <li class="active">H-Peramalan</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

    	    <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">List History Peramalan</h3>
                </div>
                <div class="box-body">
                  <table id="h-peramalan" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>KODE BARANG</th>
                        <th>NAMA BARANG</th>
                        <th>JUMLAH PERAMALAN</th>
                        <th>JUMLAH PENGADAAN</th>
                        <th>PERIODE</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $oHP = new Peramalan();
                        $rowHP = $oHP->getHistoryPeramalan();
                        while ($hasil = $rowHP->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><?php echo inputFilter($hasil['kode_bahan']);?></td>
                        <td><?php echo inputFilter($hasil['nama_bahan']);?></td>
                        <td><?php echo inputFilter($hasil['jumlah_peramalan']);?></td>
                        <td><?php echo inputFilter($hasil['jumlah_pengadaan']);?></td>
                        <td><?php echo inputFilter($hasil['periode']);?></td>
                      </tr>
                      <?php
                        }
                        $rowHP->free();
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>KODE BARANG</th>
                        <th>NAMA BARANG</th>
                        <th>JUMLAH PERAMALAN</th>
                        <th>JUMLAH PENGADAAN</th>
                        <th>PERIODE</th>
                      </tr>
                    </tfoot>
                  </table>
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
  <!-- DATA TABES SCRIPT -->
  <script src="../../asset/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../asset/plugins/datatables/dataTables.bootstrap.min.js"></script>

  <script type="text/javascript">
    $(function () {
      $("#h-peramalan").dataTable({
        "order":[[4,"desc"]]
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
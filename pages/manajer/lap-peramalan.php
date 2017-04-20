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
$tree_laporan = 'active';
$l_peramalan = $tree_laporan;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - L-Peramalan</title>
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
          <h1>Halaman<small>Laporan Peramalan</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
             <li><a href="<?php $_SERVER['PHP_SELF']; ?>"><i class="fa fa-file"></i> Kelola Laporan</a></li>
            <li class="active">L-Peramalan</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

    	    <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">List Laporan Peramalan</h3>
                </div>
                <div class="box-body">
                  <table id="tl-peramalan" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID PERAMALAN</th>
                        <th>TGL PERAMALAN</th>
                        <th>JUMLAH BAHAN</th>
                        <th>STATUS PENGADAAN</th>
                        <th>TERUPDATE</th>
                        <th style="width: 10px;">DETIL</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
                      $oDP = new Peramalan();
                      $rowLP = $oDP->bacaLaporan();
                      while ($hasil = $rowLP->fetch_assoc()) {
                    ?>
                      <tr>
                        <td><?php echo inputFilter($hasil['id_peramalan']);?></td>
                        <td><?php echo inputFilter($hasil['tgl_peramalan']);?></td>
                        <td><?php echo inputFilter($hasil['jumlah_bahan']);?></td>
                        <td><span class="label label-<?php echo classLabelStatPengadaan($hasil['status_pengadaan']); ?>"><?php echo inputFilter($hasil['status_pengadaan']);?></span></td>
                        <td><?php echo inputFilter($hasil['terupdate']);?></td>
                        <td style="padding: 3px;">
                          <a href="../../proces/peramalan.php?id_peramalan=<?php echo inputFilter($hasil['id_peramalan']);?>">
                          <button data-toggle="tooltip" data-original-title="Lihat Detil" class="btn btn-sm btn-success btn-flat no-margin">
                            <i class='glyphicon glyphicon-search'></i> <b>DL Peramalan</b>
                          </button>
                          </a>
                        </td>
                      </tr>
                    <?php
                      }
                      $rowLP->free();
                    ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>ID PERAMALAN</th>
                        <th>TGL PERAMALAN</th>
                        <th>JUMLAH BAHAN</th>
                        <th>STATUS PENGADAAN</th>
                        <th>TERUPDATE</th>
                        <th>DETIL</th>
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
    <?php include_once '../control-sidebar.php'; ?>
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
      $("#tl-peramalan").dataTable({
        "order":[[3,"asc"]]
      });
      $("#laporan").DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": true,
        "autoWidth": false
      });
    });
    $(document).ready(function(){
      // Show the Modal Pesan on load
      $("#myModal").modal("show");
      $("#modalLaporanP").modal("show");
    });
  </script>

  <?php
    if(isset($_SESSION['pesan'])){
  ?>
  <!-- Modal -->
    <!-- Modal Pesan -->
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
        <!-- End Modal content-->
      </div>
    </div>
    <!-- End Modal Pesan -->
  <?php
    }
    if($_SESSION['id_peramalan']){
      $id_peramalan = $_SESSION['id_peramalan'];
      $odp = Peramalan::getDataPeramalanById($id_peramalan);
  ?>
    <!-- Modal Laporan Detil Peramalan -->
    <div class="modal fade" id="modalLaporanP" role="dialog">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign"></span> Laporan Peramalan <span class="pull-right"><?php echo 'Tanggal ramal : '.$odp->tgl_peramalan; ?></span></h4>
          </div>
          <div class="callout callout-info" style="margin-bottom: 0!important;border-radius:0px;">
            <h4><i class="fa fa-info"></i> ID Peramalan : # <?php echo $odp->id_peramalan; ?></h4>
            Status Pengadaan : <?php echo $odp->status_pengadaan; ?><br>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12 invoice-col">
              <h4>Laporan peramalan bahan periode <?php echo $odp->periode; ?></h4>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-6">
                Dari
                <address>
                  <strong>Kepala Gudang CV. Fiesta Parfum</strong><br>
                  kagud@fiestapafrum.com<br>
                </address>
              </div><!-- /.col -->
              <div class="col-xs-6">
                Kepada
                <address>
                  <strong>Manajer CV. Fiesta Parfum</strong><br>
                  manager@fiestaparfum.com<br>
                </address>
              </div><!-- /.col -->
            </div>
            <div class="row">
              <div class="col-xs-12 table-responsive">
                <table id="laporan" class="table table-striped">
                  <thead>
                    <tr>
                      <th>Kode Bahan</th>
                      <th>Nama Bahan</th>
                      <th>Stok Periode <?php echo $odp->periode_kemarin; ?></th>
                      <th>Jumlah Peramalan</th>
                      <th>Jumlah Pengadaan</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
                    $oldp = new Peramalan();
                    $rowldp = $oldp->bacaDetilLaporanP($id_peramalan);
                    while ($hasil = $rowldp->fetch_assoc()) {
                  ?>
                    <tr>
                      <td><?php echo $hasil['kode_bahan']; ?></td>
                      <td><?php echo $hasil['nama_bahan']; ?></td>
                      <td><?php echo $hasil['stok']; ?></td>
                      <td><?php echo $hasil['jumlah']; ?></td>
                      <td><?php echo $hasil['total_pengadaan']; ?></td>
                    </tr>
                  <?php
                    }
                    $rowldp->free();
                  ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="modal-footer">
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="../../proces/peramalan.php?hapus_lp=1"><button class="btn btn-flat btn-default pull-left"><i class="fa fa-close"></i> Batal</button></a>
              <a href="../view/laporan-peramalan.php" target="_blank" class="btn btn-flat btn-default"><i class="fa fa-print"></i> Cetak</a>
            </div>
          </div>
          </div>
        </div>
        <!-- End Modal content-->
      </div>
    </div>
    <!-- End Modal Laporan Detil Peramalan -->
    <?php 
    }
    ?>
  <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='MGR') AND (isset($_GET['id_laporan'])) OR (isset($_SESSION['id_laporan']))){
require '../../class/pegawai.php';
require '../../class/transaksi.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$dastboard = 'active';
if(isset($_SESSION['id_laporan'])){
  $oLT = Transaksi::getDataLaporan($_SESSION['id_laporan']);
}else{
  $oLT = Transaksi::getDataLaporan($_GET['id_laporan']);
}
$_SESSION['id_laporan'] = $oLT->id_laporan;
$_SESSION['bln'] = $oLT->periode;
$_SESSION['statusLT'] = $oLT->status_pengesahan;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - DL-Transaksi</title>
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
          <h1>Halaman<small>Detil Laporan</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">DL-Transaksi</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

    	    <div class="no-print">
            <div class="callout callout-info" style="margin-bottom: 0!important;border-radius:0px;">
              <h4><i class="fa fa-info"></i> ID Laporan : # <?php echo $oLT->id_laporan; ?></h4>
              <p>Laporan Transaksi Periode : <?php echo $oLT->periode; ?></p>
            </div>
          </div>
          <section class="invoice no-margin">
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> CV. Fiesta Pafum
                <small class="pull-right">Tanggal Sekarang : <?php echo date('d/m/Y'); ?></small>
              </h2>
            </div><!-- /.col -->
          </div>

          <!-- info row -->
          <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
              <strong>ID Laporan        : </strong><?php echo $oLT->id_laporan; ?><br>
              <strong>Periode           : </strong><?php echo $oLT->periode; ?><br>
              <strong>Tgl Laporan       : </strong><?php echo $oLT->tgl_laporan; ?><br>
              <strong>Status Pengesahan : </strong><?php echo laporanStatus($oLT->status_pengesahan); ?><br>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
              Kepada
              <address>
                <strong>Manajer CV. Fiesta Parfum</strong><br>
                manager@fiestaparfum.com<br>
              </address>
            </div><!-- /.col -->
          </div>

          <!-- Table row -->
          <div class="row">
            <div class="col-xs-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Kode Bahan</th>
                    <th>Nama Bahan</th>
                    <th>Jumlah Masuk</th>
                    <th>Jumlah Keluar</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $bacaDLT = new Transaksi();
                  $rowDLT = $bacaDLT->bacaDetilLT($oLT->id_laporan);
                  while ($hasil = $rowDLT->fetch_assoc()) {
                ?>
                  <tr>
                    <td><?php echo $hasil['kode_bahan']; ?></td>
                    <td><?php echo $hasil['nama_bahan']; ?></td>
                    <td><?php echo $hasil['jumlah_m']; ?></td>
                    <td><?php echo $hasil['jumlah_k']; ?></td>
                  </tr>
                <?php
                  }
                  $rowDLT->free();
                ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="../view/laporan-transaksi.php" target="_blank" class="btn btn-flat btn-default"><i class="fa fa-print"></i> Cetak</a>
              <a href="javascript:;"
                data-toggle="modal" 
                data-target="#modalAksi"
                data-id="<?php echo $oLT->id_laporan; ?>">
                <button class="btn btn-flat btn-success pull-right <?php echo classCekStatusLT($oLT->status_pengesahan); ?>"><i class="fa fa-check"></i> Sahkan Laporan Transaksi</button>
              </a>
            </div>
          </div>
          </section>

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
  
  <script type="text/javascript">
    $(document).ready(function(){
      // Aksi Ubah Status LT
      $('#modalAksi').on('show.bs.modal', function (event) {
      var div = $(event.relatedTarget)
      var id = div.data('id')

      var modal = $(this)
      modal.find('.modal-body .id_laporan').html(id);
      modal.find('#url-ready').attr("href","../../proces/transaksi.php?ubahSPLT=TRUE&&id_laporan="+id);
      });
      // Show the Modal Pesan on load
      $("#myModal").modal("show");
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
  <!-- Modal Tanya Ubah Status Laporan -->
    <div class="modal fade" id="modalAksi" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pesan</h4>
          </div>
          <div class="modal-body">
            Apakah anda yakin akan mengesahkan laporan transaksi dengan ID <span class="text-primary"><label><p class="id_laporan"></p></label></span>?
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
            <a href="javascript:;" id="url-ready"><button type="button" style="width: 75px;" class="btn btn-primary btn-flat">Ya</button></a>
          </div>
        </div>
        <!-- End Modal content--> 
      </div>
    </div>
    <!-- End Modal Tanya Ubah Status Laporan -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
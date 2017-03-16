<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==true) AND (isset($_SESSION['kode_la'])) AND (isset($_SESSION['bln']))){
require '../../class/bahan.php';
require '../../class/transaksi.php';
require '../../proces/lib.php';
if(isset($_SESSION['id_laporan'])){
  $oLT = Transaksi::getDataLaporan($_SESSION['id_laporan']);
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SIMON FP - Laporan Transaksi Bahan Baku</title>
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
  <body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->

      <section class="invoice no-margin">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> CV. Fiesta Pafum
          </h2>
        </div><!-- /.col -->
      </div>
      <div class="row">
        <div class="col-md-12">
        <h4>Laporan transaksi bahan bulan <?php echo $_SESSION['bln']; ?></h4>
        <?php 
          if(isset($oLT)){
        ?>
        <strong>ID Laporan        : </strong><?php echo $oLT->id_laporan; ?><br>
        <strong>Periode           : </strong><?php echo $oLT->periode; ?><br>
        <strong>Tgl Laporan       : </strong><?php echo $oLT->tgl_laporan; ?><br>
        <strong>Status Pengesahan : </strong><?php echo laporanStatus($oLT->status_pengesahan); ?><br>
        <?php 
          }
        ?>
        </div>
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
              $oltrans = new Bahan();
              $rowolt = $oltrans->bacaLaporanTransaksi($_SESSION['bln']);
              while ($hasil = $rowolt->fetch_assoc()) {
            ?>
              <tr>
                <td><?php echo $hasil['kode_bahan']; ?></td>
                <td><?php echo $hasil['nama_bahan']; ?></td>
                <td><?php echo $hasil['jumlah_m']; ?></td>
                <td><?php echo $hasil['jumlah_k']; ?></td>
              </tr>
            <?php
              }
              $rowolt->free();
            ?>
            </tbody>
          </table>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        <div class="col-sm-12">
          <p class="lead pull-right">Tanggal Laporan <?php echo date("d/m/Y"); ?></p>
        </div>
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          Dari
          <address>
            <strong>Kepala Gudang CV. Fiesta Parfum</strong><br>
            kagud@fiestapafrum.com<br>
          </address>
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
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="laporan-transaksi.php" target="_self" class="btn btn-flat btn-default"><i class="fa fa-print"></i> Cetak</a>
          <button 
            data-bln="<?php echo $_SESSION['bln']; ?>" 
            data-id="<?php echo $_SESSION['id_laporan']; ?>" 
            data-toggle="modal" 
            data-target="<?php echo getModalByLA($_SESSION['kode_la']);?>" 
            class="btn btn-flat btn-success pull-right <?php echo classCekStatusLT($_SESSION['statusLT']); ?>">
          <i class="fa fa-check"></i> <?php echo getButtonTextByLA($_SESSION['kode_la']); ?></button>
        </div>
      </div>
    </section>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="../../asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/app.min.js" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        // Simpan Laporan Transaksi
        $('#myModalSimpanLaporan').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget)
        var bln = div.data('bln')

        var modal = $(this)
        modal.find('.modal-body .bln').html(bln);
        modal.find('#url-ready').attr("href","../../proces/bahan.php?simpan_lt=TRUE&&bln="+bln);
        })
        // Aksi Ubah Status LT
        $('#myModalUSLT').on('show.bs.modal', function (event) {
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
    <!-- Modal -->
    <?php
      if(isset($_SESSION['pesan'])){
    ?>
      <!-- Modal Pesan -->
      <div class="modal fade" id="myModalPesan" role="dialog">
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
      <!-- End Modal Pesan -->
    <?php
      }
    ?>
      <!-- Modal Tanya Simpan Laporan -->
      <div class="modal fade" id="myModalSimpanLaporan" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pesan</h4>
            </div>
            <div class="modal-body">
              Apakah anda yakin akan menyimpan laporan transaksi sekarang?
            </div>
            <div class="modal-footer">
              <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
              <a href="javascript:;" id="url-ready"><button type="button" style="width: 75px;" class="btn btn-primary btn-flat">Ya</button></a>
            </div>
          </div> 
        </div>
      </div>
      <!-- End Modal Tanya Simpan Laporan -->
      <!-- Modal Tanya Ubah Status Laporan -->
    <div class="modal fade" id="myModalUSLT" role="dialog">
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
    <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
<?php session_start(); 
require '../../proces/koneksi.php'; 
require '../../class/peramalan.php';
$dataPeramalan = Peramalan::getDataPeramalan();
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']!='') AND (($dataPeramalan) OR (isset($_SESSION['id_peramalan'])))){
require '../../class/bahan.php';
require '../../proces/lib.php';
if(isset($_SESSION['id_peramalan'])){
  $oLP = Peramalan::getDataPeramalanById($_SESSION['id_peramalan']);
}else{
  $oLP = Peramalan::getDataPeramalan();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SIMON FP - Laporan Pengajuan Bahan Baku</title>
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
            <small class="pull-right">Tanggal Peramalan : <?php echo $oLP->tgl_peramalan; ?></small>
          </h2>
        </div><!-- /.col -->
      </div>
      <div class="row">
        <div class="col-xs-12">
        <strong>ID Laporan        : </strong><?php echo $oLP->id_peramalan; ?><br>
        <strong>Periode           : </strong><?php echo $oLP->periode; ?><br>
        <strong>Status Pengadaan  : </strong><?php echo $oLP->status_pengadaan; ?><br>
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
                <th>Stok Saat Ini</th>
                <th>Jumlah Peramalan</th>
                <th>Jumlah Pengadaan</th>
              </tr>
            </thead>
            <tbody>
            <?php 
              $bacaBahanRamal = new Peramalan();
              if($_SESSION['kode_la']=='MGR'){
                $rowtdp = $bacaBahanRamal->bacaDetilLaporanP($_SESSION['id_peramalan']);
              }else{
                $rowtdp = $bacaBahanRamal->bacaDetilPeramalan();
              }
              while ($hasil = $rowtdp->fetch_assoc()) {
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
              $rowtdp->free();
            ?>
            </tbody>
          </table>
        </div><!-- /.col -->
      </div><!-- /.row -->
      <div class="row">
        <div class="col-sm-12">
          <p class="lead pull-right">Tertanda Pada Tanggal <?php echo date("d/m/Y"); ?></p>
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
          <a href="laporan-peramalan.php" target="_self" class="btn btn-flat btn-default"><i class="fa fa-print"></i> Cetak</a>
          <a href="javascript:;" data-id="<?php echo $dataPeramalan->id_peramalan; ?>" data-toggle="modal" data-target="#myModalPengadaan">
            <button class="btn btn-flat btn-success pull-right <?php echo classCekKLA($_SESSION['kode_la']); ?>"><i class="fa fa-check"></i> Proses Pengadaan</button>
          </a>
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
        // Pengadaan
        $('#myModalPengadaan').on('show.bs.modal', function (event) {
        $(this).find('#pengadaan-true').attr('href', $(event.relatedTarget).data('id'));
        $('.id_peramalan').html($(this).find('#pengadaan-true').attr('href'));
        var div = $(event.relatedTarget)
        var id = div.data('id')
        var modal = $(this)
        modal.find('#pengadaan-true').attr("href","../../proces/peramalan.php?pengadaan="+id); 
        });
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
      <!-- Modal Tanya Pengadaan -->
      <div class="modal fade" id="myModalPengadaan" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Pesan</h4>
            </div>
            <div class="modal-body">
              Apakah anda yakin telah mencetak hasil peramalan & akan mengakhiri peramalan terhadap <b>ID Peramalan</b> <span class="text-primary"><label><p class="id_peramalan"></p></label></span>?
            </div>
            <div class="modal-footer">
              <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
              <a href="javascript:;" id="pengadaan-true"><button type="button" style="width: 75px;" class="btn btn-primary btn-flat">Ya</button></a>
            </div>
          </div> 
        </div>
      </div>
      <!-- End Modal Tanya Pengadaan -->
    <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
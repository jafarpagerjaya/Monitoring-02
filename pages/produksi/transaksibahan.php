<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='PRD')){
require '../../class/pegawai.php';
require '../../class/bahan.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$transaksi = 'active';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Transaksi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../asset/plugins/select2/select2.min.css">
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
  | SKINS         | skin-purple                          |
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
          <h1>Halaman<small>Transaksi</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Transaksi</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

          <div class="row">
            <div class="col-md-6">
              <div class="box box-success">
                <form action="../../proces/bahan.php" method="POST">
                <div class="box-header with-border">
                  <h3 class="box-title">Form Transaksi Masuk</h3>
                </div>
                <div class="box-body">
                  <div class="form-group">
                  <label for="inputKB">Kode Bahan</label>
                  <select id="inputKB" name="kode_bahan" class="form-control" required>
                    <option value="">Kode Bahan</option>
                    <?php 
                      $dataKB = new Bahan();
                      $rowbkb = $dataKB->dataBahan();
                      while($hasil = $rowbkb->fetch_assoc()){ ?>
                    <option value="<?php echo $hasil['kode_bahan']; ?>"><?php echo strtoupper($hasil['nama_bahan']).' [' .strtoupper($hasil['kode_bahan']).']'; ?></option>
                    <?php 
                      } 
                      $rowbkb->free(); 
                    ?>
                  </select>
                  <label for="inputJTM">Jumlah</label>
                    <input class="form-control" type="text" name="jumlah" id="inputJTM" placeholder="Jumlah" required="">
                  </div>
                </div>
                <div class="box-footer">
                  <div class="form-group">
                    <button name="trans_masuk" type="submit" style="width: 75px;" class="btn btn-sm btn-primary btn-flat no-margin pull-right"><span>Proses</span></button>
                    <button type="reset" style="width: 75px;" class="btn btn-sm btn-default btn-flat no-margin pull-left"><span>Reset</span></button>
                  </div>
                </div>
                </form>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box box-danger">
                <form action="../../proces/bahan.php" method="POST">
                <div class="box-header with-border">
                  <h3 class="box-title">Form Transaksi Keluar</h3>
                </div>
                <div class="box-body">
                  <div class="form-group">
                  <label for="inputKB">Kode Bahan</label>
                  <select id="inputKB" name="kode_bahan" class="form-control" required>
                    <option value="">Kode Bahan</option>
                    <?php
                      $rowbkb = $dataKB->dataBahan();
                      while($hasil = $rowbkb->fetch_assoc()){ ?>
                    <option value="<?php echo $hasil['kode_bahan']; ?>"><?php echo strtoupper($hasil['nama_bahan']).' [' .strtoupper($hasil['kode_bahan']).']'; ?></option>
                    <?php 
                      } 
                      $rowbkb->free(); 
                    ?>
                  </select>
                  <label for="inputJTK">Jumlah</label>
                    <input class="form-control" type="text" name="jumlah" id="inputJTK" placeholder="Jumlah" required="">
                  </div>
                </div>
                <div class="box-footer">
                  <div class="form-group">
                    <button name="trans_keluar" type="submit" style="width: 75px;" class="btn btn-sm btn-primary btn-flat no-margin pull-right"><span>Proses</span></button>
                    <button type="reset" style="width: 75px;" class="btn btn-sm btn-default btn-flat no-margin pull-left"><span>Reset</span></button>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>

    	    <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Data Transaksi Bahan</h3>
                  <div class="box-tools pull-right">
                    <button data-toggle="modal" data-target="#myModalLaporan" class="btn btn-sm btn-info btn-flat"><b>Laporan</b> <i class="glyphicon glyphicon-plus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <table id="transaksi" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID TRANSAKSI</th>
                        <th>KODE BAHAN</th>
                        <th>JENIS TRANSAKSI</th>
                        <th>JUMLAH</th>
                        <th>SISA STOK</th>
                        <th>TGL TRANSAKSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $bacaBahan = new Bahan();
                        $rowttb = $bacaBahan->bacaTransaksi();
                        while ($hasil = $rowttb->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><?php echo inputFilter($hasil['id_transaksi']);?></td>
                        <td><?php echo inputFilter($hasil['kode_bahan']);?></td>
                        <td><?php echo inputFilter($hasil['jenis_transaksi']);?></td>
                        <td><?php echo inputFilter($hasil['jumlah']);?></td>
                        <td><?php echo inputFilter($hasil['sisa']);?></td>
                        <td><?php echo inputFilter($hasil['tgl_transaksi']);?></td>
                      </tr>
                      <?php
                        }
                        $rowttb->free();
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>ID TRANSAKSI</th>
                        <th>KODE BAHAN</th>
                        <th>JENIS TRANSAKSI</th>
                        <th>JUMLAH</th>
                        <th>SISA STOK</th>
                        <th>TGL TRANSAKSI</th>
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
  <!-- Input Mask Money -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" type="text/javascript"></script>
  <!-- Select2 -->
  <script src="../../asset/plugins/select2/select2.min.js"></script>

  <script type="text/javascript">
    $(function () {
      $("#transaksi").dataTable({
        "order":[[0,"desc"]]
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
      // Input Mask
      $("#inputJTM").maskMoney({thousands:'.', decimal:',', precision:0});
      $("#inputJTK").maskMoney({thousands:'.', decimal:',', precision:0});
      // Show the Modal Pesan on load
      $("#myModalPesan").modal("show");
      $("#myModalLaporanTransaksi").modal("show");
      // Modal Pesan LT
      $('#myModalPesanLT').on('show.bs.modal', function (event) {
      var div = $(event.relatedTarget)
      var bln = div.data('bln')

      var modal = $(this)
      modal.find('.modal-body .bln').html(bln);
      modal.find('#url-ready').attr("href","../../proces/bahan.php?simpan_lt=TRUE&&bln="+bln);
      })
      // Show the Modal Pesan on load
      $("#myModalPesan").modal("show");
      // Initialize Select2 Elements
      $(".select2").select2();
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
    <!-- Modal Form Laporan -->
    <div class="modal fade" id="myModalLaporan" role="dialog">
      <div class="modal-dialog modal-sm">
        <form name="" action="../../proces/bahan.php" method="POST">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Laporan Transaksi</h4>
          </div>
          <div class="modal-body">
            <label for="inputBLN">Bulan</label>
            <select name="bln" class="form-control select2" style="width: 100%;" required>
              <?php
                $otrans = new Bahan();
                $rowbln = $otrans->getBulanTransaksi();
                while($hasil = $rowbln->fetch_assoc()){ ?>
              <option value="<?php echo $hasil['bln']; ?>"><?php echo $hasil['bln']; ?></option>
              <?php 
                } 
                $rowbln->free(); 
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
            <button type="submit" name="laporan" style="width: 75px;" class="btn btn-primary btn-flat">Proses</button>
          </div>
        </div>
        <!-- End Modal content-->
        </form>
      </div>
    </div>
    <!-- End Modal Form Laporan -->
    <?php 
      if(isset($_SESSION['bln'])){ 
    ?>
    <!-- Modal Laporan Transaksi -->
    <div class="modal fade" id="myModalLaporanTransaksi" role="dialog">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-exclamation-sign"></span> Laporan Transaksi <span class="pull-right"><?php echo date('m/Y'); ?></span></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12 invoice-col">
              <h4>Laporan transaksi bahan bulan <?php echo $_SESSION['bln']; ?></h4>
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
              </div>
            </div>
          </div>
          <div class="modal-footer">
          <!-- this row will not appear when printing -->
          <div class="row no-print">
            <div class="col-xs-12">
              <a href="../../proces/bahan.php?hapus_lt=1" id="batal-true"><button class="btn btn-flat btn-default pull-left"><i class="fa fa-close"></i> Batal</button></a>
              <a href="../view/laporan-transaksi.php" target="_blank" class="btn btn-flat btn-default"><i class="fa fa-print"></i> Cetak</a>
              <button class="btn btn-flat btn-success pull-right" data-bln="<?php echo $_SESSION['bln']; ?>" data-toggle="modal" data-target="#myModalPesanLT"><i class="fa fa-check"></i> Simpan Laporan Transaksi</button>
            </div>
          </div>
          </div>
        </div>
        <!-- End Modal content-->
      </div>
    </div>
    <!-- End Modal Laporan Transaksi -->
    <?php } ?>
    <!-- Modal Pesan Laporan Transaksi -->
    <div class="modal fade" id="myModalPesanLT" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pesan</h4>
          </div>
          <div class="modal-body">
            Apakah anda yakin akan menyimpan laporan transaksi bahan <b>periode</b> <span class="text-primary"><label><p class="bln"></p></label></span> sekarang?
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Tidak</button>
            <a href="javascript:;" id="url-ready"><button type="button" style="width: 75px;" class="btn btn-primary btn-flat">Ya</button></a>
          </div>
        </div> 
      </div>
    </div>
    <!-- End Modal Pesan Laporan Transaksi -->
  <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}

?>
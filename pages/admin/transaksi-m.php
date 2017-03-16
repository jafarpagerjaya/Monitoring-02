<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='ADM')){
require '../../class/pegawai.php';
require '../../class/bahan.php';
include '../../class/transaksi.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$transaksi_adm = 'active';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Transaksi Master</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- AdminLTE Skins -->
    <link href="../../asset/dist/css/skins/skin-purple.min.css" rel="stylesheet">
    <!-- DATA TABES -->
    <link href="../../asset/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="../../asset/plugins/iCheck/all.css" rel="stylesheet" type="text/css">
    <!-- Select2 -->
    <link rel="stylesheet" href="../../asset/plugins/select2/select2.min.css">
    <!-- datepicker3 -->
    <link rel="stylesheet" href="../../asset/plugins/datepicker/datepicker3.css"/>
    <!-- Theme style -->
    <link href="../../asset/dist/css/AdminLTE.min.css" rel="stylesheet">
    <style>
      .datepicker{z-index:1151 !important;}
    </style>
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
          <h1>Halaman<small>Transaksi Master</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Transaksi Master</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Data Transaksi Bahan</h3>
                  <div class="box-tools pull-right">
                    <button data-toggle="modal" data-target="#modalTM" class="btn btn-sm btn-info btn-flat"><b>Tambah</b> <i class="glyphicon glyphicon-plus"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <table id="transaksi-m" class="table table-bordered table-hover">
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
  <!-- Input Mask Money -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" type="text/javascript"></script>
  <!-- iCheck 1.0.1 -->
  <script src="../../asset/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
  <!-- Select2 -->
  <script src="../../asset/plugins/select2/select2.min.js"></script>
  <!-- datepicker3 -->
  <script src="../../asset/plugins/datepicker/bootstrap-datepicker.js"></script>
  <script type="text/javascript">
    $(function () {
      $("#transaksi-m").dataTable({
        "order":[[0,"desc"]]
      });
      // Input Mask
      $("#inputJTM,#inputJTK").maskMoney({thousands:'.', decimal:',', precision:0});
      // Show the Modal Pesan on load
      $("#modalPesan").modal("show");
      // iCheck for checkbox and radio inputs
      $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
      });
      // Initialize Select2 Elements
      $(".select2").select2();
      // datepicker
      $('#periode').datepicker({
          format: "M-yyyy",
          startView: 1,
          minViewMode: 1,
          autoclose: true,
          language: "en",
          endDate: <?php echo cekLastDayOfMonth(); ?>
          startDate: "-7m"
      });
    });
  </script>
  <!-- Modal -->
    <!-- Modal Pesan -->
  <?php
    if(isset($_SESSION['pesan'])){
  ?>
    <div class="modal fade" id="modalPesan" role="dialog">
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
  <?php
    }
  ?>
    <!-- End Modal Pesan-->
    <!-- Modal Form TM -->
    <div class="modal fade" id="modalTM" role="dialog">
      <div class="modal-dialog modal-sm">
        <form name="" action="../../proces/transaksi.php" method="POST">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Transaksi Master</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="form-group">
                <label for="inputKB">Kode Bahan</label>
                <select name="kode_bahan" class="form-control select2" style="width: 100%;" required>
                <?php
                  $obahan = new Bahan();
                  $rowKB = $obahan->dataBahan();
                  while($hasil = $rowKB->fetch_assoc()){ ?>
                  <option value="<?php echo $hasil['kode_bahan']; ?>"><?php echo strtoupper($hasil['nama_bahan']).' [' .strtoupper($hasil['kode_bahan']).']'; ?></option>
                <?php 
                  } 
                  $rowKB->free(); 
                ?>
                </select>
              </div>
              <div class="form-group">
                <label for="periode">Periode</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input name="periode" class="form-control pull-right" id="periode" required>
                </div><!-- /.input group -->
              </div><!-- /.form group -->
              <div class="form-group">
                <label for="inputJTM">Jumlah</label>
                <div class="row">
                  <div class="col-md-6"><input class="form-control" type="text" name="jumlahm" id="inputJTM" placeholder="Masuk" required></div>
                  <div class="col-md-6"><input class="form-control" type="text" name="jumlahk" id="inputJTK" placeholder="Keluar" required></div>
                </div>
              </div>
            </div><!-- /.form group -->
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
            <button type="submit" name="transaksi_master" style="width: 75px;" class="btn btn-primary btn-flat">Proses</button>
          </div>
        </div>
        <!-- End Modal content-->
        </form>
      </div>
    </div>
    <!-- End Modal Form TM -->
  <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
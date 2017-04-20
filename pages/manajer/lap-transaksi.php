<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='MGR')){
require '../../class/pegawai.php';
require '../../class/transaksi.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$tree_laporan = 'active';
$l_transaksi = $tree_laporan;
unset($_SESSION['id_laporan']);
unset($_SESSION['bln']);
unset($_SESSION['statusLT']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - L-Transaksi</title>
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
    <style type="text/css">.label-buatan{border:1px;padding:7px 11px 8px;font-size:12px}</style>
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
          <h1>Halaman<small>Laporan Transaksi</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php $_SERVER['PHP_SELF']; ?>"><i class="fa fa-file"></i> Kelola Laporan</a></li>
            <li class="active">L-Transaksi</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

    	    <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">List Laporan Transaksi</h3>
                </div>
                <div class="box-body">
                  <table id="transaksi" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>ID LAPORAN</th>
                        <th>PERIODE</th>
                        <th>TGL LAPORAN</th>
                        <th style="width: 40px;">STATUS</th>
                        <th>TERUPDATE</th>
                        <th style="width: 39px;">AKSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $oBLT = new Transaksi();
                        $rowLT = $oBLT->bacaLaporan();
                        while ($hasil = $rowLT->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><?php echo inputFilter($hasil['id_laporan']);?></td>
                        <td><?php echo inputFilter($hasil['periode']);?></td>
                        <td><?php echo inputFilter($hasil['tgl_laporan']);?></td>
                        <td>
                          <span 
                           data-toggle="tooltip" 
                           data-original-title="<?php echo laporanStatus($status_pengesahan = inputFilter($hasil['status_pengesahan']));?>" 
                           data-placement="right" 
                           class="label-buatan bg-<?php echo classBgLaporanStatus($status_pengesahan);?>">
                          <i class='glyphicon glyphicon-<?php echo classIconLaporanStatus($status_pengesahan)?>'></i>
                          </span>
                        </td>
                        <td><?php echo inputFilter($hasil['terupdate']);?></td>
                        <td style="padding: 3px;">
                          <div class="box-tools pull-right">
                            <a href="dl-transaksi.php?id_laporan=<?php echo inputFilter($hasil['id_laporan']);?>">
                            <button data-toggle="tooltip" data-original-title="Lihat Detil" class="btn btn-sm btn-primary btn-flat no-margin">
                              <i class='glyphicon glyphicon-search'></i>
                            </button>
                            </a>
                            <?php
                              if($status_pengesahan=='B'){
                            ?>
                              <a href="javascript:;"
                              data-toggle="modal" 
                              data-target="#modalAksi" 
                              data-id="<?php echo inputFilter($hasil['id_laporan']);?>"
                              data-aksi="<?php echo $status_pengesahan;?>">
                              <button data-toggle="tooltip" data-original-title="Sahkan" class="btn btn-sm btn-danger btn-flat no-margin">
                                <i class='glyphicon glyphicon-off'></i>
                              </button>
                              </a>
                            <?php 
                              }else{
                            ?>
                              <button data-toggle="tooltip" data-original-title="Sahkan" class="btn btn-sm btn-info btn-flat no-margin disabled">
                                <i class='glyphicon glyphicon-off'></i>
                              </button>
                            <?php 
                              }
                            ?>
                          </div>
                        </td>
                      </tr>
                      <?php
                        }
                        $rowLT->free();
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>ID LAPORAN</th>
                        <th>PERIODE</th>
                        <th>TGL LAPORAN</th>
                        <th>STATUS</th>
                        <th>TERUPDATE</th>
                        <th>AKSI</th>
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
      $("#transaksi").dataTable({
        "order":[[5,"asc"]]
      });
    });
    $(document).ready(function(){
      // Aksi Sahkan
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
  <!-- Modal -->
  <?php
    if(isset($_SESSION['pesan'])){
  ?>
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
  ?>
  <!-- Modal Power -->
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
    <!-- End Modal Power -->
  <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==true) AND ($_SESSION['kode_la']=='MGR')){
require '../../class/pegawai.php';
require '../../class/jabatan.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$pegawai = 'active';
$job = new Jabatan();
$rowtj = $job->getJabatan();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP | Kelola Pegawai</title>
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
    <!-- DATA TABLES -->
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
          <h1>Halaman<small>Pegawai</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pegawai</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->
          <div class="row">
            <div class="col-md-12">
              <div class="box box-info collapsed-box">
                <div class="box-header with-border">
                  <h3 class="box-title">Data Pegawai</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-sm btn-info" data-widget="collapse">Tambah Data Pegawai <i class="fa fa-plus"></i></button>
                  </div>
                </div>
                <div class="box-body box-body-none">
                  <form name="" action="../../proces/pegawai.php" method="POST">
                    <div class="col-md-12">
                      <label for="inputTND"><h4>Formulir Tambah Pegawai</h4></label>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input class="form-control" name="nip" value="<?php echo $seqNip = Pegawai::getNipSelanjutnya(); ?>" maxlength="10" type="text" placeholder="NIP Karyawan Baru" readonly>
                        </div>
                        <div class="form-group">
                          <input id="inputTND" class="form-control textuppercase" name="nama_depan" maxlength="15" type="text" placeholder="Nama Depan" required>
                        </div>
                        <div class="form-group">
                          <input class="form-control textuppercase" name="nama_belakang" maxlength="35" type="text" placeholder="Nama Belakang" required>
                        </div>
                        <div class="form-group">
                          <input class="form-control textlowercase" name="email" type="email" placeholder="E-mail Karyawan Baru" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <input class="form-control" name="kontak" type="text" placeholder="Nomer Telepon Karyawan Baru" data-inputmask="'mask': '0899-9999-9999'" required>
                        </div>
                        <div class="form-group"> 
                          <label>Jabatan</label>
                          <select name="kode_la" class="form-control" required>
                            <option value="">Jabatan</option>
                            <?php 
                              while($hasil = $rowtj->fetch_assoc()){ 
                            ?>
                            <option value="<?php echo $hasil['kode_la']; ?>"><?php echo ' [' .strtoupper($hasil['kode_la']). ']'.ucwords($hasil['nama_la']); ?></option>
                            <?php 
                              } 
                              $rowtj->free();
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6 col-xs-6">
                        <div class="form-group">
                          <button type="reset" style="width: 75px;" class="btn btn-sm btn-default btn-flat no-margin pull-right"><span>Reset</span></button>
                        </div>  
                      </div>
                      <div class="col-md-6 col-xs-6">
                        <div class="form-group">
                          <button type="submit" name="simpan" style="width: 75px;" class="btn btn-sm btn-primary btn-flat no-margin pull-left"><span>Simpan</span></button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div><!-- /.box-body for form-->
                <span style="display: block;">
                <div class="box-body" style="display: block; border-top: 1px solid #f4f4f4;">
                  <table id="pegawai" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>NIP</th>
                        <th>NAMA</th>
                        <th>E-EMIL</th>
                        <th>NO TELEPON</th>
                        <th>JABATAN</th>
                        <th>TERUPDATE</th>
                        <th style="width: 39px;">AKSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $bacaEmp = new Pegawai();
                        $rowtp = $bacaEmp->dataPegawai();
                        while ($hasil = $rowtp->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><?php echo inputFilter($hasil['nip']);?></td>
                        <td><?php echo strtoupper(inputFilter($hasil['nama_depan'])).' '.strtoupper(inputFilter($hasil['nama_belakang']));?></td>
                        <td><?php echo strtolower(inputFilter($hasil['email']));?></td>
                        <td><?php echo inputFilter($hasil['kontak']);?></td>
                        <td><?php echo inputFilter($hasil['nama_la']);?></td>
                        <td><?php echo inputFilter($hasil['terupdate']);?></td>
                        <td style="padding: 3px;">
                          <div class="box-tools pull-right">
                            <a href="javascript:;"
                              data-nip="<?php echo inputFilter($hasil['nip']); ?>" 
                              data-namadpn="<?php echo ucfirst(inputFilter($hasil['nama_depan'])); ?>" 
                              data-namabkg="<?php echo ucfirst(inputFilter($hasil['nama_belakang'])); ?>"
                              data-email="<?php echo strtolower(inputFilter($hasil['email'])); ?>"
                              data-kontak="<?php echo inputFilter($hasil['kontak']); ?>" 
                              data-kodela="<?php echo strtoupper(inputFilter($hasil['kode_la'])); ?>"
                              data-toggle="modal" data-target="#myModalUbah">
                              <button class="btn btn-sm btn-warning btn-flat no-margin"><i class='glyphicon glyphicon-pencil'></i></button>
                            </a>
                            <a href="javascript:;" data-nip="<?php echo inputFilter($hasil['nip']); ?>" data-toggle="modal" data-target="#myModalHapus">
                              <button class="btn btn-sm btn-danger btn-flat no-margin"><i class='glyphicon glyphicon-trash'></i></button>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <?php
                        }
                        $rowtp->free();
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>NIP</th>
                        <th>NAMA</th>
                        <th>E-EMIL</th>
                        <th>NO TELEPON</th>
                        <th>JABATAN</th>
                        <th>TERUPDATE</th>
                        <th>AKSI</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
                </span>
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
   <!-- Input Mask -->
  <script src="../../asset/plugins/input-mask/jquery.inputmask.js" type="text/javascript"></script>
  <script type="text/javascript">
    $(function () {
      $("#pegawai").dataTable();
      // Input Mask
      $(":input").inputmask();
      // Show the Modal on load
      $("#myModal").modal("show");
    });
    $(document).ready(function(){
      // Hapus
      $('#myModalHapus').on('show.bs.modal', function (event) {
      $(this).find('#hapus-true').attr('href', $(event.relatedTarget).data('nip'));
      $('.nip').html($(this).find('#hapus-true').attr('href'));
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      // Untuk mengambil nilai dari data-id="" yang telah ditempatkan pada link hapus
      var nip = div.data('nip')
      var modal = $(this)
      // Mengisi atribut href pada tombol Ya yang telah berikan id hapus-true pada modal
      modal.find('#hapus-true').attr("href","../../proces/pegawai.php?hapus="+nip); 
      });
      // Edit
      $('#myModalUbah').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
        // Untuk mengambil nilai dari data-id="" yang telah ditempatkan pada link 

        var nip = div.data('nip')
        var namadpn = div.data('namadpn')
        var namabkg = div.data('namabkg')
        var email = div.data('email')
        var kontak = div.data('kontak')
        var kodela = div.data('kodela')

        $(".nip").val(nip);
        $(".namadpn").val(namadpn);
        $(".namabkg").val(namabkg);
        $(".email").val(email);
        $(".kontak").val(kontak);
        $(".kodela").val(kodela);
      });
      $(".textuppercase").keyup(function () {
        this.value = this.value.toLocaleUpperCase();
      });
      $(".textlowercase").keyup(function () {
        this.value = this.value.toLocaleLowerCase();
      });
    });
  </script>
  <!-- Js Statment -->
  <script src="../../asset/main.js" type="text/javascript"></script>

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
      </div>
    </div>
    <!-- End Modal Pesan -->
  <?php
    }
  ?>
    <!-- Modal Form Edit -->
    <div class="modal fade" id="myModalUbah" role="dialog">
      <div class="modal-dialog modal-md">
      <form name="" action="../../proces/pegawai.php" method="POST">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Edit Data Pegawai</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                    <input class="form-control nip" name="nip" type="hidden">
                    <label>NIP</label>
                    <input class="form-control nip" type="text" disabled>
                    <label for="inputEND">Nama Depan</label>
                    <input class="form-control namadpn " name="nama_depan" style="text-transform: uppercase;" type="text" id="inputEND" required>
                    <label for="inputENB">Nama Belakang</label>
                    <input class="form-control namabkg" name="nama_belakang" style="text-transform: uppercase;" type="text" id="inputENB" required>
                  </div>
                </div><!-- /.col-md-6 col-sm-6 -->
                <div class="col-md-6 col-sm-6">
                  <div class="form-group">
                    <label for="inputEEP">E-mail</label>
                    <input class="form-control email" name="email" style="text-transform: lowercase;" type="email" id="inputEEP" required>
                    <label for="inputETP">No Telepon</label>
                    <input class="form-control kontak" name="kontak" type="text" id="inputETP" required data-inputmask="'mask': '0899-9999-9999'">
                    <label>Jabatan</label>
                    <select name="kode_la" class="form-control kodela" required>
                    <?php 
                      $rowej = $job->getJabatan();
                      while($hasil = $rowej->fetch_assoc()){ 
                    ?>
                      <option value="<?php echo $hasil['kode_la']; ?>"><?php echo ' [' .strtoupper($hasil['kode_la']). ']'.ucwords($hasil['nama_la']); ?></option>
                    <?php 
                      } 
                      $rowej->free(); 
                    ?>
                    </select>
                  </div>
                </div><!-- /.col-md-6 col-sm-6 -->
              </div><!-- /.row -->
            </div>
            <div class="modal-footer">
              <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" name="ubah" style="width: 75px;" class="btn btn-primary btn-flat">Update</button>
            </div>
        </div>
        <!-- End Modal content-->
      </form>
      </div>
    </div>
    <!-- End Modal Form Edit -->
    <!-- Modal Hapus -->
    <div class="modal fade" id="myModalHapus" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pesan</h4>
          </div>
          <div class="modal-body">
            Apakah anda yakin menghapus data pegawai dengan NIP <span class="text-primary"><label><p class="nip"></p></label></span>?
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
            <a href="javascript:;" id="hapus-true"><button type="button" style="width: 75px;" class="btn btn-primary btn-flat">Ya</button></a>
          </div>
        </div> 
        <!-- End Modal content-->
      </div>
    </div>
    <!-- End Modal Hapus -->
  <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
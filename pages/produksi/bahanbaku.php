<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']='PRD')){
require '../../class/pegawai.php';
require '../../class/bahan.php';
require '../../class/peramalan.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$bahanbaku = 'active';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Bahan Baku</title>
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
    <!-- AdminLTE Skins -->
    <link href="../../asset/dist/css/skins/skin-purple.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link href="../../asset/dist/css/AdminLTE.min.css" rel="stylesheet">
    <!-- Override style -->
    <link href="../../asset/dist/css/main.css" rel="stylesheet">
    <!-- DATA TABES -->
    <link href="../../asset/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../asset/plugins/iCheck/square/blue.css" rel="stylesheet">
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
          <h1>Halaman<small>Bahan Baku</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Bahan Baku</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

          <div class="row">
            <div class="col-md-12">
              <div class="box box-info collapsed-box">
                <div class="box-header">
                  <h3 class="box-title">Daftar Data Bahan</h3>
                  <div class="box-tools pull-right">
                    <button data-toggle="modal" data-target="#myModalRamal" class="btn btn-sm btn-success btn-flat"><b>Forecast</b> <i class="glyphicon glyphicon-plus"></i></button>
                    <button data-toggle="modal" data-target="#myModalTambah" class="btn btn-sm btn-info btn-flat"><b>Tambah</b> <i class="glyphicon glyphicon-plus"></i></button>
                  </div>
                </div>
                <div class="box-body box-body-none">
                </div>
                <span style="display: block;">
                <div class="box-body" style="display: block;">
                  <table id="bahanbaku" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>KODE BAHAN</th>
                        <th>NAMA BAHAN</th>
                        <th>HARGA PER LITER (Rp)</th>
                        <th>STOK</th>
                        <th>STOK AMAN</th>
                        <th>TERUPDATE</th>
                        <th style="width: 39px;">AKSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $bacaBahan = new Bahan();
                        $rowtb = $bacaBahan->dataBahan();
                        while ($hasil = $rowtb->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><?php echo inputFilter($hasil['kode_bahan']);?></td>
                        <td><?php echo inputFilter($hasil['nama_bahan']);?></td>
                        <td><?php echo inputFilter($hasil['harga_pl']);?></td>
                        <td><?php echo inputFilter($hasil['stok']).' ('.inputFilter($hasil['status stok']).')';?></td>
                        <td><?php echo inputFilter($hasil['stok_aman']);?></td>
                        <td><?php echo inputFilter($hasil['terupdate']);?></td>
                        <td style="padding: 3px;">
                          <div class="box-tools pull-right">
                            <a href="javascript:;"
                              data-kode="<?php echo inputFilter($hasil['kode_bahan']); ?>" 
                              data-nama="<?php echo inputFilter($hasil['nama_bahan']); ?>" 
                              data-harga="<?php echo inputFilter($hasil['harga_pl']); ?>"
                              data-stok="<?php echo inputFilter($hasil['stok']).' ('.inputFilter($hasil['status stok']).')'; ?>"
                              data-toggle="modal" data-target="#myModalUbah">
                              <button class="btn btn-sm btn-warning btn-flat no-margin"><i class='glyphicon glyphicon-pencil'></i></button>
                            </a>
                            <a href="javascript:;" data-kode="<?php echo inputFilter($hasil['kode_bahan']); ?>" data-toggle="modal" data-target="#myModalHapus">
                              <button class="btn btn-sm btn-danger btn-flat no-margin"><i class='glyphicon glyphicon-trash'></i></button>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <?php
                        }
                        $rowtb->free();
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>KODE BAHAN</th>
                        <th>NAMA BAHAN</th>
                        <th>HARGA PER LITER (Rp)</th>
                        <th>STOK</th>
                        <th>STOK AMAN</th>
                        <th>TERUPDATE</th>
                        <th>AKSI</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div> 
          </div>
          <?php 
            $dataPeramalan = Peramalan::getDataPeramalan();
            if($dataPeramalan){
          ?>
          <div class="no-print">
            <div class="callout callout-info" style="margin-bottom: 0!important;border-radius:0px;">
              <h4><i class="fa fa-info"></i> ID Peramalan : # <?php echo $dataPeramalan->id_peramalan; ?></h4>
              Daftar Bahan Mentah Yang Diramalkan 
            </div>
          </div>
          <section class="invoice no-margin">
          <!-- title row -->
          <div class="row">
            <div class="col-xs-12">
              <h2 class="page-header">
                <i class="fa fa-globe"></i> CV. Fiesta Pafum
                <small class="pull-right">Tanggal Peramalan : <?php echo $dataPeramalan->tgl_peramalan; ?></small>
              </h2>
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
                    <th>Stok Saat Ini</th>
                    <th>Jumlah Peramalan</th>
                    <th>Jumlah Pengadaan</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                  $bacaBahanRamal = new Peramalan();
                  $rowtdp = $bacaBahanRamal->bacaDetilPeramalan();
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
              <a href="../view/laporan-peramalan.php" target="_blank" class="btn btn-flat btn-default"><i class="fa fa-print"></i> Cetak</a>
              <a href="javascript:;" data-id="<?php echo $dataPeramalan->id_peramalan; ?>" data-toggle="modal" data-target="#myModalPengadaan">
                <button class="btn btn-flat btn-success pull-right"><i class="fa fa-check"></i> Proses Pengadaan</button>
              </a>
            </div>
          </div>
        </section>
        <?php
        }
        ?>

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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" type="text/javascript"></script>
  <!-- Select2 -->
  <script src="../../asset/plugins/select2/select2.min.js"></script>
  <!-- iCheck -->
  <script src="../../asset/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

  <script type="text/javascript">
    $(function () {
      $("#bahanbaku").dataTable();
      // iCheck
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
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
      // Hapus
      $('#myModalHapus').on('show.bs.modal', function (event) {
      $(this).find('#hapus-true').attr('href', $(event.relatedTarget).data('kode'));
      $('.kode_bahan').html($(this).find('#hapus-true').attr('href'));
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      // Untuk mengambil nilai dari data-id="" yang telah ditempatkan pada link hapus
      var kode = div.data('kode')
      var modal = $(this)
      // Mengisi atribut href pada tombol Ya yang telah berikan id hapus-true pada modal
      modal.find('#hapus-true').attr("href","../../proces/bahan.php?hapus="+kode); 
      });
      // Edit
      $('#myModalUbah').on('show.bs.modal', function (event) {
        var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
        // Untuk mengambil nilai dari data-id="" yang telah ditempatkan pada link 

        var kode = div.data('kode')
        var nama = div.data('nama')
        var harga = div.data('harga')
        var stok = div.data('stok')

        $(".kode").val(kode);
        $(".nama").val(nama);
        $(".harga").val(harga);
        $(".stok").val(stok);
      });
      $(".textuppercase").keyup(function () {
        this.value = this.value.toLocaleUpperCase();
      });
      // Input Mask
      $("#inputHarga").maskMoney({prefix:'Rp. ', thousands:'.', decimal:',', precision:0});
      $("#inputEHB").maskMoney({thousands:'.', decimal:',', precision:0});
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
    <!-- Modal Form Forecast -->
    <div class="modal fade" id="myModalRamal" role="dialog">
      <div class="modal-dialog modal-sm">
      <form name="" action="../../proces/bahan.php" method="POST">    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Tambah Data Bahan</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="inputKB">Kode Bahan</label>
              <select name="kode_bahan" class="form-control select2" style="width: 100%;" required>
                <?php 
                  $rowtb2 = $bacaBahan->dataBahanRamal();
                  if($rowtb2){
                    while($hasil = $rowtb2->fetch_assoc()){ ?>
                      <option value="<?php echo $hasil['kode_bahan']; ?>"><?php echo strtoupper($hasil['nama_bahan']).' [' .strtoupper($hasil['kode_bahan']).']'; ?></option>
                <?php 
                    } 
                    $rowtb2->free(); 
                  }
                ?>
              </select>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <p class="text-center">- ATAU -</p>
                <div class="checkbox icheck">
                  <label>
                    <input name="ramal_semua" type="checkbox"> Pilih Semua Bahan
                  </label>
                </div>
              </div>
          </div>
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
            <button type="submit" name="ramal" style="width: 75px;" class="btn btn-primary btn-flat">Ramal</button>
          </div>
        </div>
      </form>
      </div>
    </div>
    <!-- End Modal Form Forecast -->
    <!-- Modal Form Tambah Bahan -->
    <div class="modal fade" id="myModalTambah" role="dialog">
      <div class="modal-dialog modal-sm">
      <form name="" action="../../proces/bahan.php" method="POST">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Tambah Data Bahan</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="inputKB">Kode Bahan</label>
                <input class="form-control" minlength="5" maxlength="5" name="kode_bahan" style="text-transform: uppercase;" type="text" id="inputKB" required>
                <label for="inputNB">Nama Bahan</label>
                <input class="form-control textuppercase"  maxlength="20" name="nama_bahan" style="text-transform: uppercase;" type="text" id="inputNB" required>
                <label for="inputHarga">Harga Per Liter</label>
                <input class="form-control" name="harga_pl" type="text" id="inputHarga" required>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" name="simpan" style="width: 75px;" class="btn btn-primary btn-flat">Simpan</button>
            </div>
        </div>
      </form>
      </div>
    </div>
    <!-- End Modal Form Tambah Bahan -->
    <!-- Modal Form Edit Bahan -->
    <div class="modal fade" id="myModalUbah" role="dialog">
      <div class="modal-dialog modal-sm">
      <form name="" action="../../proces/bahan.php" method="POST">    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Edit Data Bahan</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <input class="form-control kode" name="kode_bahan" type="hidden">
                <label>Kode Bahan</label>
                <input class="form-control kode" type="text" disabled>
                <label for="inputEND">Nama Bahan</label>
                <input class="form-control nama" name="nama_bahan" style="text-transform: uppercase;" type="text" id="inputENB" required>
                <label for="inputENB">Harga Per Liter (Rp)</label>
                <input class="form-control harga" name="harga_pl" style="text-transform: uppercase;" type="text" id="inputEHB" required>
                <label>Stok Bahan (L)</label>
                <input class="form-control stok" type="text" disabled>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" name="ubah" style="width: 75px;" class="btn btn-primary btn-flat">Update</button>
            </div>
        </div>
      </form>
      </div>
    </div>
    <!-- End Modal Form Edit Bahan -->
    <!-- Modal Hapus Bahan -->
    <div class="modal fade" id="myModalHapus" role="dialog">
      <div class="modal-dialog modal-sm">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pesan</h4>
          </div>
          <div class="modal-body">
            Apakah anda yakin menghapus data bahan dengan <b>KODE</b> <span class="text-primary"><label><p class="kode_bahan"></p></label></span>?
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
            <a href="javascript:;" id="hapus-true"><button type="button" style="width: 75px;" class="btn btn-primary btn-flat">Ya</button></a>
          </div>
        </div> 
      </div>
    </div>
    <!-- End Modal Hapus Bahan -->
  <!-- End Modal -->
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}

?>
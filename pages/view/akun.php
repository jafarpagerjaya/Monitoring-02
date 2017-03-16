<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='MGR') OR ($_SESSION['kode_la']=='ADM')){
require '../../class/pegawai.php';
include '../../class/akun.php';
require '../../class/percakapan.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
$akun = 'active';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Akun</title>
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

    <style>
    .chat-box{
      display: none;
      position: fixed;
      background: white;
      right: 95px;
      bottom: 0px;
      height: auto;
      width: 280px;
      border: 1px solid #ececec;
      z-index: 2;
    }
    .box-direct-h{
      padding: 15px 10px;
      cursor: pointer;
    }
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
          <h1>Halaman<small>Akun</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Akun</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

          <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header">
                  <h3 class="box-title">Daftar Data Akun</h3>
                </div>
                <div class="box-body">
                  <table id="akun" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>NIP</th>
                        <th>ACTIVE</th>
                        <th>ONLINE</th>
                        <th>TERUPDATE</th>
                        <th>JABATAN</th>
                        <th>AKSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $bacaAkun = new Akun();
                        $rowta = $bacaAkun->dataAkun();
                        while ($hasil = $rowta->fetch_assoc()) {
                      ?>
                      <tr>
                        <td><?php echo inputFilter($hasil['nip']);?></td>
                        <td style="padding: 7px 8px 7px 3px;">
                          <span 
                           data-toggle="tooltip" 
                           data-original-title="<?php echo akunStatus($aktif = inputFilter($hasil['aktif']));?>" 
                           data-placement="right" 
                           class="label-buatan bg-<?php echo classBgAkunStatus($aktif);?>">
                          <i class='glyphicon glyphicon-<?php echo classIconAkunStatus($aktif)?>'></i>
                          </span>
                          <p style="display: none"><?php echo $aktif;?></p>
                        </td>
                        <td>
                        <?php if($hasil['nip']!=$_SESSION['nip']){ ?>
                          <a href="javascript:;"
                            data-toggle="tooltip" 
                            data-original-title="Klik untuk chat" 
                            data-placement="left" 
                            class="popup-chatbox"
                            data-id="<?php echo $hasil['nip']; ?>"
                            data-nla="<?php echo $hasil['nama_la']; ?>">
                        <?php } ?>
                            <span class="<?php echo classAkun(inputFilter($hasil['online'])); ?>"></span> <?php echo statusAkun(inputFilter($hasil['online']));?>
                        <?php if($hasil['nip']!=$_SESSION['nip']){ ?> 
                          </a> 
                        <?php } ?>
                        </td>
                        <td>
                          <span class="timeago" title="<?php echo date("c", strtotime(inputFilter($hasil['terupdate']))); ?>"></span>
                        </td>
                        <td><?php echo strtoupper(inputFilter($hasil['nama_la']));?></td>
                        <td style="padding: 3px;">
                          <div class="box-tools pull-right">
                            <a href="javascript:;" 
                              data-nip="<?php echo inputFilter($hasil['nip']); ?>" 
                              data-email="<?php echo inputFilter($hasil['email']); ?>"
                              data-toggle="modal" 
                              data-target="#modalAksi" 
                              data-aksi="<?php echo setAksiAkun($aktif);?>">
                              <button 
                                data-toggle="tooltip" 
                                data-original-title="<?php echo tooltipAkunStatus($aktif);?>" 
                                class="btn btn-sm btn-<?php echo classBtnAkunStatus($aktif);?> btn-flat no-margin">
                                <i class='glyphicon glyphicon-off'></i>
                              </button>
                            </a>
                          </div>
                        </td>
                      </tr>
                      <?php
                        }
                        $rowta->free();
                      ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>NIP</th>
                        <th>ACTIVE</th>
                        <th>ONLINE</th>
                        <th>TERUPDATE</th>
                        <th>JABATAN</th>
                        <th>AKSI</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div> 
          </div>

        </section><!-- /.content -->

        <div class="chat-box">
          <div class="box box-primary direct-chat direct-chat-primary no-margin">
            <div class="box-header with-border box-direct-h" style="padding: 15px 10px;">
              <h3 class="box-title nla"></h3>
              <div class="box-tools pull-right" style="top: 10px;">
                <button class="btn btn-box-tool remove-popup"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-direct-bf">
            <div class="box-body">
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">
                <div id="show_message">
                  
                </div>
              </div>
              <!-- End Conversations -->
            </div>
            <div class="box-footer no-padding">
              <form action="#" method="POST">
                <div class="form-group">
                  <textarea id="message" name="pesan" class="form-control" rows="3" placeholder="Ketik text ..."></textarea>
                </div>
              </form>
            </div>
            </div>
          </div>
        </div>
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
  <script src="../../asset/dist/js/timeago.idn.js"></script>
  <script type="text/javascript">
    $(function () {
      $("#akun").dataTable();
      // Input Mask
      $("#myModal").modal("show");
      // Chat
      $(".popup-chatbox").on("click", function (event) {
        var nip = $(this).data('id');
        var nla = $(this).data('nla');
        $.ajax({
          url: '../../proces/p-chat.php',
          type: 'post',
          async: false,
          data: { "tampil" : 1,
                  "nip" : nip
                },
          success: function(data){
            $('#show_message').html(data);
          }
        });
        $(".chat-box").css("display", "block");
        $(".box-direct-bf").show();
        $(".nla").html(nla);
        $('.direct-chat-messages').scrollTop($('.direct-chat-messages')[0].scrollHeight);

        $("#message").keypress(function (e) {
          if (e.keyCode == 13) {
            var msg = $(this).val();
            msg = msg.trim();
            $.ajax({
              url: '../../proces/p-chat.php',
              type: 'post',
              async: false,
              data: { "nip" : nip,
                      "msg" : msg
                    },
              success: function(data){
                $("#message").val("");
                e.preventDefault();
              }
            });
          }
        });
      });
      $(".box-direct-h").on("click", function (event) {
        $(".box-direct-bf").slideToggle("fast");
      });
      $(".remove-popup").on("click", function (event) {
        var nip = $(this).data('id');
        $(".chat-box").css("display", "none");
      });
    });
    jQuery(document).ready(function() {    
      $(".timeago").timeago();
    });
    $(document).ready(function(){
      // Blokir Akun
      $('#modalAksi').on('show.bs.modal', function (event) {
      var div = $(event.relatedTarget)

      var nip = div.data('nip')
      var email = div.data('email')
      var aksi = div.data('aksi')

      var modal = $(this)
      modal.find('.modal-body .nip').html(nip);
      modal.find('.modal-body .email').html(email);
      modal.find('.modal-body .aksi').html(aksi);
      modal.find('#url-ready').attr("href","../../proces/auth.php?aksi="+aksi+"&&email="+email+"&&nip="+nip);
      });
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
                if (isset($_SESSION['kirimEmailReAktivasiAkun'])) { // return hasil reak kirim ke email {
                  echo '<br>'.$_SESSION['kirimEmailReAktivasiAkun'];
                  unset($_SESSION['kirimEmailReAktivasiAkun']);
                }
            ?>
          </div>
        </div>
        <!-- Modal content-->
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
            Apakah anda yakin akan <label class="aksi"></label> akun pegawai dengan NIP <span class="text-primary"><label><p class="nip"></p></label></span>?
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
  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}
?>
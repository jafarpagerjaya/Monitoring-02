<?php 
session_start();
require '../../proces/lib.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Pendaftaran</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link href="../../asset/dist/css/AdminLTE.min.css" rel="stylesheet">
    <!-- Override style -->
    <link href="../../asset/dist/css/main.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../../asset/plugins/iCheck/square/blue.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="../../index.php"><b>SIMON</b>FP</a>
      </div>
      <div class="register-box-body">
        <p class="login-box-msg">Daftar sebagai pengguna baru</p>
        <form action="../../proces/auth.php" method="post">
          <div class="form-group has-feedback">
            <input id="nip" type="text" name="nip" minlength="10" maxlength="10" class="form-control" placeholder="NIP" required/>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input id="email" type="text" name="email" maxlength="32" class="form-control textlowercase" placeholder="Email" required/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div id="pwd-container">
            <div class="form-group has-feedback no-margin">
              <input id="password" type="password" minlength="6" name="password" class="form-control" placeholder="Password" required/>
              <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group">
                <div class="progress_meter"></div>
            </div>
          </div>
          <div class="form-group has-feedback">
            <input id="retype_password" type="password" name="retypepassword" class="form-control" placeholder="Retype password" required/>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox" required> Saya setuju <a href="#" id="ketentuan">ketentuan</a>
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="register" class="btn btn-primary btn-block btn-flat">Register</button>
            </div><!-- /.col -->
          </div>
        </form>        

        <div class="social-auth-links text-center">
          <p>- ATAU -</p>
        </div>

        <a href="signin.php" class="text-center">Saya sudah punya akun sistem</a>
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../../asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="../../asset/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- zxcvbn -->
    <script src="../../asset/plugins/pwstrenght/zxcvbn.js" type="text/javascript"></script>
    <!-- pwstrenght -->
    <script src="../../asset/plugins/pwstrenght/pwstrength-bootstrap.min.js" type="text/javascript"></script>
    <!-- Js Statment -->
    <script src="../../asset/main.js" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        $(".textlowercase").keyup(function () {
          this.value = this.value.toLocaleLowerCase();
        });
        "use strict";
        var options = {};
        options.ui = {
            container: "#pwd-container",
            showVerdicts: false,
            viewports: {
                progress: ".progress_meter"
            }
        };
        options.common = {
            zxcvbn: true,
            userInputs: ['#nip', '#email']
        }
        $('#password').pwstrength(options);
      });
    </script>
    <!-- Modal -->
      <!-- Modal Pesan-->
      <?php if(isset($_SESSION['pesan'])){ ?>
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-<?php echo classModal($_SESSION['pesan']); ?>">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Pesan</h4>
              </div>
              <div class="modal-body">
                <?php
                    echo $_SESSION['pesan'];//.' '.$_SESSION['statusKirimEmailAktivasiAkun']; return test hasil kirim emial
                    unset($_SESSION['pesan']);
                    unset($_SESSION['statusKirimEmailAktivasiAkun']);
                ?>
              </div>
            </div>
            <!-- End Modal content-->
          </div>
        </div>
      <?php } ?>
      <!-- End Modal Pesan -->
      <!-- Modal Ketentuan -->
      <div class="modal fade" id="myModalKetentuan" role="dialog">
        <div class="modal-dialog modal-md">
          <!-- Modal content Ketentuan -->
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ketentuan Penggunaan Sistem</h4>
            </div>
            <div class="modal-body">
              <h5>Dengan menceklist ini saya setuju dengan ketentuan <label class="text-info">Fiesta Parfum</label> sebagai berikut :</h5>
              <div class="media no-margin">
                <div class="pull-left">
                  <p>1.</p> 
                </div>
                <div class="media-body text-left">
                  <p>Saya berjanji akan bekerja secara profesional di tempat saya berkerja saat ini.</p>
                </div>
              </div>
              <div class="media no-margin">
                <div class="pull-left">
                  <p>2.</p> 
                </div>
                <div class="media-body text-left">
                  <p>Udah itu saja.</p>
                </div>
              </div>
            </div>
          </div>
          <!-- End Modal content-->
        </div>
      </div>
      <!-- End Modal Ketentuan -->
    <!-- End Modal -->
  </body>
</html>
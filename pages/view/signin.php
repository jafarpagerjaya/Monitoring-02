<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Sign in</title>
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
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="../../index.php"><b>SIMON</b>FP</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Sign in untuk masuk ke sistem</p>
        <form action="../../proces/auth.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" name="email" class="form-control" placeholder="Email" required/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" class="form-control" placeholder="Password" required/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <a href="#" id="lupaPassword">Lupa password</a><br>
              <a href="register.php" class="text-center">Mendaftarkan akun baru</a>              
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="signin" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div><!-- /.col -->
          </div>
        </form>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="../../asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../../asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="../../asset/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- Js Statment -->
    <script src="../../asset/main.js" type="text/javascript"></script>

    <!-- Modal -->
      <!-- Modal Pesan -->
      <?php if(isset($_SESSION['pesan'])) { ?>
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-sm">
            <!-- Modal content Pesan -->
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Pesan</h4>
              </div>
              <div class="modal-body">
                <?php
                    echo $_SESSION['pesan'];
                    unset($_SESSION['pesan']);
                    // if (isset($_SESSION['kirimEmailLupaPassword'])) { // return hasil lupa pass kirim ke email {
                    //   echo '<br>'.$_SESSION['kirimEmailLupaPassword'];
                    //   unset($_SESSION['kirimEmailLupaPassword']);
                    // }
                ?>
              </div>
            </div>
            <!-- End Modal content Pesan -->
          </div>
        </div>
      <?php } ?>
      <!-- End Modal Pesan -->
      <!-- Modal Lupa Password -->
      <form action="../../proces/auth.php" method="POST">
      <div class="modal fade" id="myModalLupaPassword" role="dialog">
        <div class="modal-dialog modal-sm">
          <!-- Modal content Lupa Password -->
          <div class="modal-content">
            <form action="" method="post">
              <div class="modal-header">
                <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Lupa Password</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="inputEmail">E-mail</label>
                  <input class="form-control jabatan" name="email" type="email" id="inputEmail" required>
                </div>
                <div class="checkbox icheck">
                  <label>
                    <input type="checkbox" required> Saya Manusia
                  </label>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
                <button name="lupa_password" type="submit" style="width: 75px;" class="btn btn-primary btn-flat">Kirim</button>
              </div>
            </form>
          </div>
          <!-- End Modal content Lupa Password -->
        </div>
      </div>
      </form>
      <!-- End Modal Lupa Password -->
    <!-- End Modal -->
  </body>
</html>
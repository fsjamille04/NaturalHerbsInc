<?php
session_start();
include("dbconnection.php"); 
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Natural Herbs Pharm </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="icon" href="dist/img/icon.png">
  <style type="text/css">
  html,body{
        height: 100%
    } 

    .login-page {
        min-height: 100%;
        position:relative;
    }

    body {
        padding-bottom: 100px;
    }

    footer{ 
        bottom: 0;
        height: 100px;
        left: 0;
        position: absolute;
        right: 0;
        text-align: center;
    }
  </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo col-md-12">
            <img src="dist/img/logo11.png">
            <a href="">Natural Herbs Pharm Inc.</a>
        </div>
      <!-- /.login-logo -->
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Sign in to start your session</p>

          <form action="" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="User" name="username1">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" placeholder="Password" name="password">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="icheck-primary">
                  <input type="checkbox" id="remember">
                  <label for="remember">
                    Remember Me
                  </label>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-4">
                <button type="submit" name="contact_submit" class="btn btn-primary btn-block">Sign In</button>
              </div>
              <!-- /.col -->
            </div>
            <?php

                if (isset($_POST['contact_submit'])) {

                $uname = $_POST['username1']; 
                $pass = $_POST['password'];

                if ($result = $conn->query("SELECT * FROM admiN321 where username1='$uname' and password0='$pass'")) {
                if($result->num_rows !=0){
                $mres = mysqli_fetch_assoc($result);                            
                  echo "<script> window.location.href = 'index.php'; </script>";                                                       

                $_SESSION['pdid2'] = $mres['adminid0'];
                }else{
                 echo "Invalid Username or Password!";
                }
                $result->close();    
                }   

                }

          ?>
          
          </form>
          
        </div>

        <!-- /.login-card-body -->
      </div>
    </div>
    <footer>
        <div >  
                All rights reserved.
                <br/><strong>Copyright &copy; 2017 <a href="#">NaturalHerbsPharm Corp</a>.</strong>
                <div style="margin-top: 2px;">
                    Developed by <a href="https://www.facebook.com/jamille.tinaco"> Jamille Tinaco</a> 
                </div>

        </div>
    </footer>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

</body>
</html>

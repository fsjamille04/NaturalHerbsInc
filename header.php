<?php   

include ('dbconnection.php'); 
session_start();
$id = $_SESSION['pdid2'];
if(!isset($_SESSION['pdid2']) || (trim($_SESSION['pdid2']) == '')) {
    header("location: login.php");
    exit();
}  
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Natural Herbs Pharm | Health and make some money</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Bootstrap Picker -->
  <link rel="stylesheet" href="dist/css/bootstrap-datepicker.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="icon" href="dist/img/icon.png">
  <style type="text/css">
    a.active {
      color: #ffffff;
      background-color: #007bff;
    } 
  @media print {
    body * {
      visibility: hidden;
    }
    #PrintModal,
    #PrintModal * {
         visibility:visible;
         /* margin-top:-1px;*/
             
    }
    #PrintModal {
      position: absolute;
      left: -200px;
      top: 0; 
    }
    #PrintModal table{
      padding-left: 60px !important;
    }
    #PrintModal table.payout_table, table.payout_table td, table.payout_table th {
      padding : 5px 15px !important;
      padding-bottom: : 0 !important; 
      font-size: 12px;
    }
     
  } 
  @page { size: auto;  margin: 0mm; }
    table.payout_table, table.payout_table td, table.payout_table th{ 
      padding-right: 75px;
      padding-left:  5px; 
      padding-bottom: 5px;
    }
    table.unilvl_bonus2, table.unilvl_bonus2 td, table.unilvl_bonus2 th{ 
      padding-right: 85px;
      padding-left:  5px; 
      padding-bottom: 5px;
    }
     
  </style>  
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

   <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/icon.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Natural Hebrs Pharm</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/avatar3.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="index.php" id="index" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                 Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="old-member.php" id="old-member" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Old Members
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="new-member.php" id="new-member" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                 New Members
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="referral-payout.php" id="referral" class="nav-link">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>
                Referral Payout
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="unilevel-payout.php"  id="unilevel" class="nav-link">
              <i class="nav-icon fas fa-money-bill-alt"></i>
              <p>
                Unilevel Payout
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="register-client.php" id="register" class="nav-link">
              <i class="nav-icon far fa-registered"></i>
              <p>
                Register
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="repurchase.php" id="repurchase" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Repurchase
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="purchase-history.php" id="history" class="nav-link">
              <i class="nav-icon fas fa-history"></i>
              <p>
                Purchase History
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="product-register.php" id="product" class="nav-link">
              <i class="nav-icon fab fa-product-hunt"></i>
              <p>
                Additional Product
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="code.php" id="code" class="nav-link">
              <i class="nav-icon fas fa-qrcode"></i>
              <p>
                Codes
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
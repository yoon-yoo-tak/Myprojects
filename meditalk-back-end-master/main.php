<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <!--제이쿼리-->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
</head>

<body id="page-top">
  <h1>
  <?php
    session_start();
    
    if(!isset($_SESSION['user_id'])){
       header("Location:/index.html");
    }
     
  ?>
  <h1>
  <?php
    
    $hp_id = $_SESSION['user_id'];
    $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
    $office_query = "SELECT * FROM OfficeHours WHERE hp_id='$hp_id'";
    $office_res = mysqli_query($con,$office_query);
    $staff_query = "SELECT * FROM MedicalStaff WHERE hp_id='$hp_id'";
    $staff_res =  mysqli_query($con,$staff_query);
    $hp_query = "SELECT * FROM Hospital WHERE hp_id='$hp_id'";
    $hp_obj = mysqli_fetch_array(mysqli_query($con,$hp_query));
  ?>
  </h1>
  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" style="background:white;"href="index.html">
        <!-- <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div> -->
        <img src="img/logo_txt.png">
        
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      
      <!--예약현황-->
      <li class="nav-item active">
        <a class="nav-link" onclick="reserStatus();">
          <i class="glyphicon glyphicon-home"></i>
          <span>예약현황</span></a>
      </li>
      <hr class="sidebar-divider">
      <!--처방전 작성-->
      <li class="nav-item active">
        <a class="nav-link" onclick="prescription();">
          <i class="glyphicon glyphicon-home"></i>
          <span>처방전 작성</span></a>
      </li>
      
      <!--<div class="sidebar-heading">
        Interface
      </div> -->

      <!-- Nav Item - Pages Collapse Menu -->
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Components</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
          </div>
        </div>
      </li> -->


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
    
        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <div  class="text-center" style=" width:100%;color:rgb(52,68,110); font-size:22px; position:relative; top:6px;"><b><?= $hp_obj['hp_name'] ?></b></div>
          <!-- Topbar Search -->
          <!--
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
          -->
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $hp_obj['hp_admin_name'] ?></span>
                <img class="img-profile rounded-circle" src="img/user.png">
                
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" onclick="logout();" data-toggle="modal" data-target="#logoutModal" style="cursor:point;">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
            
          <?php 
            if(empty(mysqli_fetch_array($office_res))){
              include('office_hours_form.html');
            }else if(empty(mysqli_fetch_array($staff_res))){
              include('staff_form.html');
            }else{
              include('reserStatus.php');
            }
          ?>
                
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Long 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <script>
      function logout(){
           
           window.location.href="/logout.php";
      }
      function home(){
           window.location.href="/main.php";
      }
      //예약현황 페이지 로드
      function reserStatus(){
        
        ajax("reserStatus.php");
      }
      //처방전 작성 페이지 로드
      function prescription(){
        ajax("prescription_form.html");
      }
      function ajax(page){
        $.ajax({
                type : 'GET',
                url : page,
                
                success : function (data) {
                   $(".container-fluid").empty();
                   $(".container-fluid").append(data);
                }
            });
      }

  </script>  


</body>

</html>

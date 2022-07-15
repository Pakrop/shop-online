<?php 
@session_start(); 
if(!isset($_SESSION['admin'])){
    header('location: admin-signin.php');
    exit;
}
?>
<?php require 'meta.php'?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">
    <?php require 'admin-navbar.php'?>
    <?php require 'admin-sidebar.php'?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

            

      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->
</body>
<?php require 'script.php'?>
<?php require 'footer.php'?>
<?php 
@session_start(); 
if(!isset($_SESSION['admin'])){
    header('location: admin-signin.php');
    exit;
}
?>
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-dark navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="admin-dashboard.php" class="nav-link">หน้าหลัก</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="admin-search_products.php" class="nav-link">จัดการสินค้า</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->
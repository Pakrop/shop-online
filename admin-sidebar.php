<?php 
@session_start(); 
if(!isset($_SESSION['admin'])){
    header('location: admin-signin.php');
    exit;
}
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/ezStoreLogo_symbol.png" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block" style="font-size: 19px; font-weight: 600;">&nbsp;ผู้ดูแลระบบ</a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="admin-add_product.php" class="nav-link">
              <i class="fas fa-cart-plus fa-lg"></i>
              <p>
                เพิ่มรายการสินค้า
              </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="signout.php" class="nav-link">
              <i class="fas fa-sign-out-alt fa-lg"></i>
              <p>
                ออกจากระบบ
              </p>
            </a>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->      
    </div>
  </aside>
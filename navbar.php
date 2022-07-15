
<style>
@import url('https://fonts.googleapis.com/css2?family=Bungee&display=swap');
    .brand-image{
        width: 40px;
        height: auto;
    }
    .navbar{
      font-size: 15px;
    }
    .navbar-brand{
      font-size: 20px;
      font-weight: 900;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a href="#" class="navbar-brand">
        <img src="dist/img/ezStoreLogo_symbol2.png" alt="EZ Logo" class="brand-image">
        <span class="brand-text font-weight-light" style="font-family: 'Bungee', cursive;">Easy-Store</span>
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="fas fa-home fa-lg"></i>&nbsp;หน้าหลัก</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-truck fa-lg"></i>&nbsp;สถานะการสั่งซื้อและจัดส่ง</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#"><i class="fas fa-cash-register fa-lg"></i>&nbsp;วิธีการชำระเงิน</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"href="#"><i class="fas fa-shopping-basket fa-lg"></i>&nbsp;ตะกร้าสินค้า</a>
      </li>
        <?php
            if(isset($_SESSION['user_name'])){
                $name = $_SESSION['user_name'];
                echo <<<html
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span><i class="fas fa-clipboard-list fa-lg"></i></span>&nbsp;ตรวจสอบ
                      </a>
                      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <h6 class="dropdown-item text-primary" style="font-size: 17px;">Welcome, $name</h6>
                          <a class="dropdown-item" href="#">ตรวจสอบรถเข็นและการสั่งซื้อ</a>
                          <a class="dropdown-item" href="#">ประวัติการสั่งซื้อ</a>
                          <a class="dropdown-item" href="user-wishlist.php">รายการที่ชอบ</a>
                          <hr class="mr-3 ml-3">
                          <a class="dropdown-item" href="user-edit.php">แก้ไขข้อมูลสมาชิก</a>
                          <a class="dropdown-item" href="signout.php">ออกจากระบบ</a>
                      </div>
                  </li>
                html;
            }else{
                echo <<<html
                  <li class="nav-item">
                      <a class="nav-link"href="user-signin.php"><span><i class="fas fa-sign-in-alt fa-lg"></i></span>&nbsp;เข้าสู่ระบบ</a>
                  </li>
                html;
            }
        ?>
      
    </ul>
  </div>
</nav>

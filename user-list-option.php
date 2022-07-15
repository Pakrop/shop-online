<?php 
@session_start(); 
    if(!isset($_SESSION['user_id'])){
        header('location: user-signin.php');
        exit;
    }
?>
<?php require 'meta.php';?>
<?php require 'navbar.php';?>
<div class="container my-5">
    <div class="row justify-content-center mt-5">
        <div class="col-lg-7 col-md-7 mt-5">
            <h4 class="text-center mb-3">สำหรับสมาชิก</h4>
            <a href="user-cart.php" class="btn btn-primary w-75 rounded-pill mb-2 mx-auto d-block">ตรวจสอบรถเข็นและการสั่งซื้อ</a>
            <a href="user-order-list.php" class="btn btn-primary w-75 rounded-pill mb-2 mx-auto d-block">ประวัติการสั่งซื้อ</a>
            <a href="user-wishlist.php" class="btn btn-primary w-75 rounded-pill mb-5 mx-auto d-block">รายการที่ชอบ</a>
            <a href="user-edit.php" class="btn btn-success w-75 rounded-pill mb-2 mx-auto d-block">แก้ไขข้อมูลสมาชิก</a>
            <a href="signout.php" class="btn btn-danger w-75 rounded-pill mb-2 mx-auto d-block">ออกจากระบบ</a>
        </div>
    </div>
</div>
<?php require 'script.php';?>
<?php require 'footer.php';?>

<footer class="text-center fixed-bottom bg-dark py-2 text-light">
    &copy;&nbsp;นายปลากรอบ&nbsp;1999-2021&nbsp;&nbsp;&nbsp;
<?php
@session_start();
if(!isset($_SESSION['user_name'])){
    if(isset($_SESSION['admin'])){
        echo <<<html
        <div class="dropdown mr-2 d-inline">
            <button class="btn btn-success btn-sm dropdown-toggle" type="button" data-toggle="dropdown">Admin</button>
            <div class="dropdown-menu p-2">
                <a class="dropdown-item" href="admin-add-product.php">เพิ่มรายการสินค้า</a>
                <a class="dropdown-item" href="admin-order-list.php">รายการสั่งซื้อ</a>
                <a class="dropdown-item" href="admin-dashboard.php">จัดการทรัพยากรต่างๆ</a>
                <a class="dropdown-item" href="signout.php">ออกจากระบบ</a>
            </div>
        </div>
        html;
    }else{
        echo '<a class="btn btn-danger btn-sm" type="button" href="admin-signin.php">เข้าสู่ระบบแอดมิน</a>';
    }
}
?>
</footer>

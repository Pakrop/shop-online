<?php
    @session_start();
    require 'ConnDB.php';
    require '../meta.php';
    if (!isset($_SESSION['user_id'])) {
        header('location: ../user-signin.php');
        exit;
    }
    if(isset($_GET['prod_id'])){
        $user_id = $_SESSION['user_id'];
        $prod_id = $_GET['prod_id'];
        
        date_default_timezone_set('Asia/Bangkok');
        $date_now = date('Y-m-d H:i:s');
        
        $sql = "SELECT * FROM product WHERE id = $prod_id";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $main = $row["main_img"];
                $name = $row["name"];
                $detail = $row["detail"];
                $price = $row["price"];
            }
        }

        $sql_insert = "INSERT INTO wishlist (user_id, prod_id, img_prod, name_prod, detail_prod, price_prod, created_prod) 
        VALUES ($user_id, $prod_id, '$main', '$name', '$detail', $price, '$date_now')";

        $message = '';
        $sql_check = "SELECT * FROM wishlist WHERE prod_id = $prod_id";
        $result_check = $conn->query($sql_check);
        if($result_check->num_rows > 0){
            $sql_insert = '';
            $message = '<div class="alert alert-danger mt-5" role="alert">
                            สินค้านี่ถูกเพิ่มเข้ารายการแล้ว <a class="alert-link" onclick="history.back()">ย้อนกลับ</a>
                        </div>';
        }else{
            $conn->query($sql_insert);
            $message = '<div class="alert alert-success mt-5" role="alert">
                            บันทึกข้อมูลสินค้าเรียบร้อยแล้ว <a class="alert-link" onclick="history.back()">ย้อนกลับ</a>
                        </div>';
        }
        $conn->close();
    }


    
    
?>
<body>
    <div class="container d-flex justify-content-center align-item-center">
        <?php echo $message; ?>
    </div>
</body>
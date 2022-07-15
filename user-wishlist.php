<?php
    @session_start();
    require 'model/ConnDB.php';
    if (!isset($_SESSION['user_id'])) {
        header('location: user-signin.php');
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM wishlist WHERE user_id = $user_id ORDER BY created_prod DESC";
    $result = $conn->query($sql);
?>
<?php require 'meta.php';?>
<?php require 'navbar.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <style>
        body{
            background: #dcdcdc;
        }
        .container-fluid{
            margin-top: 100px;
            background: #fff;
            border-radius: 10px;
        }
        .img-fluid, .card-img-top{
            width: 250px;
            height: 170px;
            border-radius: 10px;
        }
        .card{
            border-radius: 10px;
            border: 1px solid #cccccc;
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center mr-3 ml-3 mb-5">
        <div class="container-fluid mb-3">
            <p class="h2 mb-3 mt-5 text-center">รายการที่ชอบ <i class="fa fa-heart"></i></p>
            <hr>
            <?php
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        $id = $row["prod_id"];
                        $img = $row["img_prod"];
                        $name = $row["name_prod"];
                        $detail = $row["detail_prod"];
                        $price = $row["price_prod"];
                        $date = $row["created_prod"];
                        if(strlen($detail) > 143){
                            $detail_show = substr($detail,0,143);
                            $detail_show.=".....";
                        }else{
                            $detail_show = $detail;
                        }
                        echo <<<php
                        <div class="d-flex justify-content-center align-items-center">
                            <div class="card mb-3 col-lg-8 shadow">
                                <div class="row">
                                    <div class="col-md-4 d-flex justify-content-center">
                                            <img src="dist/product-img/$id/$img" class="img-fluid m-3" alt="...">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">$name</h5>
                                                <p class="card-text">$detail_show</p>
                                                <p class="card-text">ราคา: $price</small></p>                                               
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" class="btn btn-outline-primary mr-2">รายละเอียด</a>
                                                    <a href="model/user-wishlist_delete.php?prod_id=$id" class="btn btn-outline-danger">ลบ</a>
                                                </div>
                                                <p class="card-text"><small class="text-muted">ถูกบันทึกเมื่อ: $date</small></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        php;
                    }
                }else 
                {
                    echo '<p class="h5 text-center">ไม่พบรายการสินค้า</p>';
                }
            ?>      
        </div>
    </div>
</body>
</html>
<?php require 'footer.php';?>
<?php require 'script.php';?>
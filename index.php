
<?php @session_start();?>
<?php require 'meta.php';?>
<?php require 'navbar.php';?>
<?php
    require 'model/ConnDB.php';
    $search = '';
    $check_sh = false;
    $check_ca = false;
    $check_mm = false;
    $check_ft = false;
    if(!empty($_POST["search"])){
        $search = $_POST["search"];
        $check_sh = true;
    }
    
    $category = '';
    if(!empty($_POST["category"])){
        $category = $_POST["category"];
        $check_ca = true;
    }
    
    $min_max = '';
    $min_max2 = 'ASC';
    if(!empty($_POST["min_max"])){
        $check_mm = true; 
        $min_max = $_POST["min_max"];
        if($min_max == 'min'){
            $min_max2 = 'DESC';
        }
    }
    
    $to = 0;
    $from = 0;
    if(!empty($_POST["from"]) && !empty($_POST["to"])){
        $check_ft = true;
        $to = $_POST["to"];
        $from = $_POST["from"];
    }

    // ค้นหาสินค้า
    if($check_sh == true || $check_ca == true || $check_mm == true && $check_ft == false){
        $sql =  " SELECT * FROM product WHERE name LIKE '%$search%' AND category LIKE '%$category%' 
        ORDER BY price $min_max2";
    }else if($check_sh == false && $check_ca == false && $check_mm == true && $check_ft == false){
        $sql = " SELECT * FROM product WHERE price BETWEEN  $from AND $to";
    }else{
        $sql = "SELECT * FROM product";
    }

    $result = $conn->query($sql);
    
    $result_per_page = 24;
    $numb_result = $result->num_rows;
    $numb_of_page = ceil($numb_result/$result_per_page);

    // กำหนดหมายเลข page ที่แสดงในหน้าปัจจุบัน
    if(!isset($_GET['page'])){
        $page = 1;
    }else{
        $page = $_GET['page'];
    }

    $sql_page = "";
    $first_page = ($page-1)*$result_per_page;
    if($check_ft == true){
        $sql_page = $sql.' '.'LIMIT'.' '.$first_page.','.$result_per_page;
    }else if($search == null && $category == null){
        $sql_page = "SELECT * FROM product LIMIT ".$first_page.','.$result_per_page;
    }else{
        $sql_page = $sql.' '.'LIMIT'.' '.$first_page.','.$result_per_page;
    }
    echo "<p style=\"margin-top:200px;\">$sql_page</p>";
    $result_page = $conn->query($sql_page);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body{
            background: #dcdcdc;
            min-height: 100vh;
        }
        .container{
            position: relative;
            width: 1200px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            grid-gap: 20px;
            padding: 20px;
        }
        .container .card{
            width: 100%;
            background: #fff;
            border-radius: 10px;
        }
        .container .card .imgBx{
            position: relative;
            width: 100%;
            height: 230px;
            overflow: hidden;
            border-radius: 10px 10px 0 0;
        }
        .container .card .imgBx img{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .5s ease-in-out;
            transform-origin: right;
        }
        .container .card:hover .imgBx img{
            transform: scale(1.5);
        }
        .container .card .content{
            padding: 10px;
        }
        .container .card .content .productName h3{
            font-size: 18px;
            font-weight: 500;
            color: #333;
            margin: 5px 0;
        }
        .container .card .content .price_rating{
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .container .card .content .price_rating h2{
            font-size: 20px;
            color: #ff2020;
            font-weight: 500;
        }
        .container .card .content .price_rating .fas{
            color: #ffd513;
            cursor: pointer;
        }
        .action{
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .action li{
            position: relative;
            list-style: none;
            width: 40px;
            height: 40px;
            background: #fff;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 4px;
            cursor: pointer;
            transition: transform .5s;
            transform: translateX(60px);
        }
        .container .card:hover .action li{
            transform: translateX(0px);
        }
        .action li span{
            position: absolute;
            right: 50px;
            top: 50%;
            transform: translateY(-50%) translateX(-20px);
            white-space: nowrap;
            padding: 4px 40px;
            background: #fff;
            color: #333;
            font-weight: 700;
            font-size: 12px;
            border-radius: 4px;
            pointer-events: none;
            opacity: 0;
            transition: .5s;
        }
        .action li span::before{
            content: '';
            position: absolute;
            top: 50%;
            right: -4px;
            width: 8px;
            height: 8px;
            background: #fff;
            transform: translateY(-50%) rotate(45deg);
        }
        .action li:hover{
            background: #7c49f2;
            color: #fff;
        }
        .action li a{
            color : inherit;
        }
        .action li:hover span{
            opacity: 1;
            transform: translateY(-50%) translateX(0px);
        }
        .action li:nth-child(2){
            transition-delay: .15s;
        }
        .action li:nth-child(3){
            transition-delay: .3s;
        }
    </style>
</head>
<body>
    <form method="post" action="index.php">
        <div class="d-flex justify-content-start align-items-center ml-5 mb-2" style="margin-top:100px;">
            <select class="form-control w-25 mr-2" name="category" id="category">
                <option value="">หมวดหมู่ของสินค้า</option>
                <option value="เครื่องใช้ไฟฟ้า">เครื่องใช้ไฟฟ้า</option>
                <option value="เสื้อผ้า">เสื้อผ้า</option>
                <option value="เสื้อผ้าผู้หญิง">เสื้อผ้าผู้หญิง</option>
                <option value="เสื้อผ้าผู้ชาย">เสื้อผ้าผู้ชาย</option>
                <option value="เสื้อผ้าเด็ก">เสื้อผ้าเด็ก</option>
                <option value="อุปกรณ์คอมพิวเตอร์">อุปกรณ์คอมพิวเตอร์</option>
                <option value="ของใช้เบ็ตเตล็ด">ของใช้เบ็ตเตล็ด</option>
                <option value="อาหาร">อาหาร</option>
            </select>
            <input type="text" placeholder="ค้นหาด้วยชื่อสินค้า" class="form-control col-2 mr-1" name="search">
            <button class="btn btn-primary mr-2" type="submit">ค้นหา</button> 
        </div>

        <div class="d-flex justify-content-start align-items-center ml-5 mb-2">
            <select class="form-control w-25 mr-2" name="min_max" id="min_max">
                <option value="">ค้นหาด้วยจำนวนเงิน</option>
                <option value="min">จากมากไปน้อย</option>
                <option value="max">จากน้อยไปมาก</option>
            </select>
            <input type="number" placeholder="จากราคา" class="form-control col-1 mr-1" name="from">
            <input type="number" placeholder="ถึงราคา" class="form-control col-1 mr-1" name="to">
        </div>

        <div class="d-flex justify-content-start align-items-center ml-5">
            <p class="mr-3">พบสินค้าจำนวนทั้งหมด : <?=$result->num_rows?> รายการ</p>
            <p>[ราคาจาก : <?=$from?> ถึง : <?=$to?>]</p>
        </div>
    </form>
<div class="container">
       <?php
            if($result_page->num_rows > 0){
                while($row = $result_page->fetch_assoc()){
                    $id = $row["id"];
                    $main = $row["main_img"];
                    $name = $row["name"];
                    $price = $row["price"];
                    echo <<<php
                    <div class="card">
                        <div class="imgBx">
                            <img src="dist/product-img/$id/$main" alt="">
                            <ul class="action">
                                <li>
                                <a href="model/user-add_wishlist.php?prod_id=$id"><i class="fa fa-heart"></i></a>
                                    <span>เพิ่มเป็นสินค้าที่ชอบ</span>
                                </li>
                                <li>
                                <a href="user-products_detail.php?prod_id=$id"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <span>ดูรายละเอียด</span>
                                </li>
                            </ul>
                        </div>
                        <div class="content">
                            <div class="productName">
                                <h3>$name</h3>
                            </div>
                            <div class="price_rating">
                                <h2>$price</h2>
                                <div class="rating">
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                    <i class="fas fa-star" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    php;
                }
            }else 
            {
                echo "<tr><td colspan=3 ><h1>ไม่พบรายการสินค้า</h1></td></tr>";
            }
       
       ?>
   </div>

    <div class="d-flex justify-content-center align-items-center mb-5">
        <p>หน้าปัจจุบัน : <?=$page?></p>
        <nav aria-label="Page navigation example" class="ml-3">
            <ul class="pagination justify-content-center">
            <?php
                $disabled1 = '';
                $disabled2 = '';
                $page_mi = $page-1;
                $page_add = $page+1;
                if($page == 1){
                    $page_mi = 1;
                    $disabled1 = 'disabled';
                }

                if($page_add == $numb_of_page+1){
                    $page_add = $numb_of_page;
                    $disabled2 = 'disabled';
                }

                if($result->num_rows == 0){
                    $disabled2 = 'disabled';
                }
               echo "<li class=\"page-item $disabled1\">
                        <a class=\"page-link\" href=\"index.php?page=$page_mi\">Previous</a>
                     </li>";
                // แสดงลิ้งค์ของ page
                for($page=1; $page<=$numb_of_page; $page++){
                    echo '<li class="page-item">
                            <a class="page-link" href="index.php?page=' .$page. '">' .$page. '</a>
                        </li>';
                }   
                echo "<li class=\"page-item $disabled2\">
                        <a class=\"page-link\" href=\"index.php?page=$page_add\">Next</a>
                     </li>";
            ?>
            </ul>
        </nav>
    </div>
</body>
</html>
<?php require 'footer.php';?>
<?php require 'script.php';?>
<?php
    if(isset($_POST['page'])){
        include_once 'lib/pagination.class.php';
        include_once 'model/ConnDB.php';

        $baseURL = 'admin-search_products-db.php';
        $offset = !empty($_POST['page'])?$_POST['page']:0; 
        $limit = 10;

        $whereSQL = ''; 
        if(!empty($_POST['search'])){ 
            $whereSQL = " WHERE (name LIKE '%".$_POST['search']."%' OR category LIKE '%".$_POST['search']."%' OR detail LIKE '%".$_POST['search']."%') ";
        }
        
        // Count of all records 
        $query   = $conn->query("SELECT COUNT(*) as rowNum FROM product " .$whereSQL); 
        $result  = $query->fetch_assoc(); 
        $rowCount= $result['rowNum'];

        // Initialize pagination class 
        $pagConfig = array( 
            'baseURL' => $baseURL, 
            'totalRows' => $rowCount, 
            'perPage' => $limit,
            'currentPage' => $offset,  
            'contentDiv' => 'myForm', 
            'link_func' => 'searchFilter' 
        ); 
        $pagination =  new Pagination($pagConfig);
        $query = $conn->query("SELECT * FROM product $whereSQL ORDER BY id DESC LIMIT $offset,$limit");  
    }
?>
<?php require 'meta.php';?>

<style>
    .img-fluid{
        max-width: 150px;
    }
    a{
        color: inherit;
    }
    .margin{
        margin-bottom: 100px;
    }
    .border_class{
        border: 1px solid #a3a3a3;
        padding: 7px 13px 7px 13px;
        margin-bottom: 30px;
        border-radius: 20px;
    }
</style>

<title>Search Products</title>
<?php require 'admin-navbar.php';?>
<?php require 'admin-sidebar.php';?>
                <div class="col-md-10 offset-md-1 margin" id="myForm">
                    <?php
                    if($query->num_rows !== false && $query->num_rows > 0){   
                        while($row = $query->fetch_assoc()) {
                            $offset++;
                            $id = $row["id"];
                            $main = $row["main_img"];
                            $name = $row["name"];
                            $detail = $row["detail"];
                            $price = $row["price"];
                            $created = $row["created"];
                ?>      
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-auto">
                                   <a href="admin-edit_products.php?prod_id=<?=$id?>"> <img class="img-fluid" src="dist/product-img/<?=$id?>/<?=$main?>" alt="Photo"> </a>
                                </div>
                                <div class="col px-4">
                                    <div>
                                        <div class="float-right"><small class="text-muted">บันทึกข้อมูลเมื่อ: <?=$created?></small></div>
                                        <a href="admin-edit_products.php?prod_id=<?=$id?>"><h5><?=$name?></h5></a>
                                        <p class="mb-0"><?=$detail?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                                      
                <?php    }
                    } 
                    else 
                    {
                        echo "<p class=\"text-center\">ไม่พบรายการสินค้าที่ค้นหา</P";
                    }
                    $conn->close();
                ?>    
                
                    <!-- Display pagination links -->
                    <div class="d-flex justify-content-center mb-5 mt-3">
                        <div class="border_class">
                            <?php echo $pagination->createLinks(); ?>
                        </div>
                    </div>

                </div>
<?php require 'script.php';?>
<?php require 'footer.php';?>
<?php 
    @session_start(); 
    if(!isset($_SESSION['admin'])){
        header('location: admin-signin.php');
        exit;
    }
    
    include_once 'lib/pagination.class.php';
    include_once 'model/ConnDB.php';

    $baseURL = 'admin-search_products-db.php';
    $limit = 10;
    // Count of all records 
    $query   = $conn->query("SELECT COUNT(*) as rowNum FROM product"); 
    $result  = $query->fetch_assoc(); 
    $rowCount= $result['rowNum'];

    // Initialize pagination class 
    $pagConfig = array( 
        'baseURL' => $baseURL, 
        'totalRows' => $rowCount, 
        'perPage' => $limit, 
        'contentDiv' => 'myForm', 
        'link_func' => 'searchFilter' 
    ); 
    $pagination =  new Pagination($pagConfig); 
    
    // Fetch records based on the limit 
    $query = $conn->query("SELECT * FROM product ORDER BY id DESC LIMIT $limit");
   
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
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
<?php require 'admin-navbar.php';?>
<?php require 'admin-sidebar.php';?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <h2 class="text-center display-6">ค้นหาสินค้า</h2>
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid mb-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <form action="admin-search_products.php" method="POST">
                        <div class="input-group input-group-lg">
                            <input type="search" class="form-control form-control-lg" id="search" placeholder="ค้นหาด้วยชื่อสินค้า" onkeyup="searchFilter();">
                        </div>
                    </form>
                </div>
            </div>

            <div class="datalist-wrapper mb-5">
            <!-- Loading overlay -->
            <div class="loading-overlay"><div class="overlay-content text-center mt-3">Loading...</div></div>
            
            <div class="row mt-3">
                <div class="col-md-10 offset-md-1 margin" id="myForm">
                    <?php
                    if($query->num_rows > 0) 
                    {   
                        while($row = $query->fetch_assoc()) {
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
                </div>
            </div>
            </div>
        </div>
    </section>
  </div>
</div>
</body>
<?php require 'script.php';?>
<script>
$('.loading-overlay').hide();
function searchFilter(page_num) {
    page_num = page_num?page_num:0;
    var search = $('#search').val();
    $.ajax({
        type: 'POST',
        url: 'admin-search_products-db.php',
        data:'page='+page_num+'&search='+search,
        beforeSend: function () {
            $('.loading-overlay').show();
        },
        success: function (html) {
            $('#myForm').html(html);
            $('.loading-overlay').fadeOut("slow");
        }
    });
}
</script>
<?php require 'footer.php';?>
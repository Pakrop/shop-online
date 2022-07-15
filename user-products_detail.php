<?php 
    @session_start();
    require 'model/ConnDB.php';
    $prod_id = '';
    if(isset($_GET['prod_id'])){
        $prod_id = $_GET['prod_id'];
    }
    $sql = "SELECT * FROM product WHERE id = $prod_id";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $id = $row["id"];
            $name = $row["name"];
            $price = $row["price"];
            $detail = $row["detail"];
            $shoe_size = explode(",",$row["shoe_size"]);

            $shirt_size = explode(",",$row["shirt_size"]);

            $colors_arr = explode(",",$colors);

            $main_img = $row["main_img"];
            $img_file = explode(",",$row["img_file"]);
        }
    }
?>
<?php require 'meta.php';?>
<?php require 'navbar.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Product</title>0
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <style>
        .content{
            margin-top: 50px;
            background: #fff;
            border-radius: 10px;
        }
        body{
            background: #dcdcdc;
        }
        .image-w-h{
            width: 550px;
        }
        .form-control{
            border: 1px solid #a6a6a6;
        }
    </style>
</head>
<body>
    <!-- Main content -->
    <section class="content ml-3 mr-3 mb-5">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="col-12">
                <img src="dist/product-img/<?=$id?>/<?=$main_img?>" class="product-image image-w-h" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs owl-carousel">
                <div class="product-image-thumb"><img src="dist/product-img/<?=$id?>/<?=$main_img?>" alt="Product Image"></div>
                <?php
                    for($i=0;$i<count($img_file);$i++){
                        echo "<div class=\"product-image-thumb\"><img src=\"dist/product-img/$id/$img_file[$i]\" alt=\"Product Image\"></div>";
                    } 
                ?>
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3"><?=$name?></h3>
              <hr>
              <h5>สี:</h5>
              <div>
                  <?php
                        for($i=0;$i<count($colors_arr);$i++){
                            echo "<input type=\"radio\" class=\"btn-check\" value=\"$colors_arr[$i]\" name=\"btncolors\" id=\"btncolors$i\" autocomplete=\"off\">
                                <label class=\"btn btn-outline-secondary\" for=\"btncolors$i\">$colors_arr[$i]</label>";
                        }
                  ?>
              </div>

              <div>
                    <?php
                        if(!empty($shirt_size)){
                            echo "<h5 class=\"mt-3\">กรุณาเลือกไซส์เสื้อ</h5>";
                            for($j=0;$j<count($shirt_size);$j++){
                                echo "<input type=\"radio\" class=\"btn-check\" value=\"$shirt_size[$j]\" name=\"shirts\" id=\"shirt_size-$j\" autocomplete=\"off\">
                                    <label class=\"btn btn-outline-secondary\" for=\"shirt_size-$j\">$shirt_size[$j]</label>";
                            }
                        }else if(!empty($shoe_size)){
                            echo "<h5 class=\"mt-3\">กรุณาเลือกไซส์รองเท้า(UK)</h5>";
                            for($i=0;$i<count($shoe_size);$i++){
                                echo "<input type=\"radio\" class=\"btn-check\" value=\"$shoe_size[$i]\" name=\"shoes\" id=\"shoe_size-$i\" autocomplete=\"off\">
                                    <label class=\"btn btn-outline-secondary\" for=\"shoe_size-$i\">$shoe_size[$i]</label>";
                            }
                        }
                    ?>
              </div>

              <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0">
                  ฿ <?=$price?>
                </h2>
                <h4 class="mt-0">
                  <small>รวมภาษีแล้ว</small>
                </h4>
              </div>

              
              <div class="row mt-3">
                <div class="col-md-2">
                    <h4>จำนวน:</h4>
                </div>
                <div class="col-md-2 col-sm-3">
                  <input type="number" class="form-control" min="1" step="1" >
              </div>
              </div>
             

              <div class="mt-4">
                <div class="btn btn-primary btn-lg btn-flat">
                  <i class="fas fa-cart-plus fa-lg mr-2"></i>
                  Add to Cart
                </div>

                <div class="btn btn-default btn-lg btn-flat">
                  <i class="fas fa-heart fa-lg mr-2"></i>
                  Add to Wishlist
                </div>
              </div>

              <div class="mt-4 product-share">
                <a href="#" class="text-gray">
                  <i class="fab fa-facebook-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fab fa-twitter-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-envelope-square fa-2x"></i>
                </a>
                <a href="#" class="text-gray">
                  <i class="fas fa-rss-square fa-2x"></i>
                </a>
              </div>

            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"><?=$detail?></div>
              <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"> Vivamus rhoncus nisl sed venenatis luctus. Sed condimentum risus ut tortor feugiat laoreet. Suspendisse potenti. Donec et finibus sem, ut commodo lectus. Cras eget neque dignissim, placerat orci interdum, venenatis odio. Nulla turpis elit, consequat eu eros ac, consectetur fringilla urna. Duis gravida ex pulvinar mauris ornare, eget porttitor enim vulputate. Mauris hendrerit, massa nec aliquam cursus, ex elit euismod lorem, vehicula rhoncus nisl dui sit amet eros. Nulla turpis lorem, dignissim a sapien eget, ultrices venenatis dolor. Curabitur vel turpis at magna elementum hendrerit vel id dui. Curabitur a ex ullamcorper, ornare velit vel, tincidunt ipsum. </div>
              <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"> Cras ut ipsum ornare, aliquam ipsum non, posuere elit. In hac habitasse platea dictumst. Aenean elementum leo augue, id fermentum risus efficitur vel. Nulla iaculis malesuada scelerisque. Praesent vel ipsum felis. Ut molestie, purus aliquam placerat sollicitudin, mi ligula euismod neque, non bibendum nibh neque et erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh rhoncus ut. Aliquam efficitur lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit nisl. Nullam metus odio, malesuada in vehicula at, consectetur nec justo. Quisque suscipit odio velit, at accumsan urna vestibulum a. Proin dictum, urna ut varius consectetur, sapien justo porta lectus, at mollis nisi orci et nulla. Donec pellentesque tortor vel nisl commodo ullamcorper. Donec varius massa at semper posuere. Integer finibus orci vitae vehicula placerat. </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
</body>
<?php require 'footer.php';?>
<?php require 'script.php';?>
<script>
  $(document).ready(function() {
    $('.product-image-thumb').on('click', function () {
      var $image_element = $(this).find('img')
      $('.product-image').prop('src', $image_element.attr('src'))
      $('.product-image-thumb.active').removeClass('active')
      $(this).addClass('active')
    })

    $(".owl-carousel").owlCarousel({
        center: true,
        items:15,
        loop:false,
        margin:3,
        responsiveClass:true,
        responsive:{
            0:{
                items:3,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
    });

  })
</script>
</html>


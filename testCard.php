<style>
    /* div.gallery {
        border: 1px solid #ccc;
    }

    div.gallery:hover {
        border: 1px solid #777;
    }

    div.gallery img {
        width: 120px;
        height: auto;
        position: relative;
    }

    div.desc {
        padding: 15px;
        text-align: center;
        font-size: 12px;
    }

    .responsive {
        padding: 0 6px;
        float: left;
        width: 140px;
    } */
    .img-container{
        width: 100px;
        height: auto;
    }
</style>
<?php require 'meta.php';?>
<?php require 'navbar.php';?>
<br><br><br>
<div class="container-fluid mt-1">
    <div class="owl-carousel owl-theme">
        <div class="item">
            <div class="img-container">
                <a href="#">
                    <img src="https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832__480.jpg">
                </a>
                <h4>asddasd</h4>
            </div>
        </div>

        <div class="item">
            <a href="#">
                <img src="https://p4.wallpaperbetter.com/wallpaper/500/442/354/outrun-vaporwave-hd-wallpaper-preview.jpg">
            </a>
            <h4>asddasd</h4>
        </div>
    </div>
    <!-- <div class="responsive">
        <div class="gallery">
            <a href="#">
                <img src="https://cdn.pixabay.com/photo/2018/01/14/23/12/nature-3082832__480.jpg" alt="">
            </a>
            <div class="desc">rtdfsdfasdefsafasdasdad</div>
        </div>
    </div> -->
</div>
<?php require 'script.php';?>
<script>
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        loop:false,
        margin:10,
        responsiveClass:true,
        responsive:{
            0:{
                items:5,
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
</script>
<?php require 'footer.php';?>
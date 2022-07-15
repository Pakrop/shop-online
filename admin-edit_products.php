<?php
    @session_start(); 
    if(!isset($_SESSION['admin'])){
        header('location: admin-signin.php');
        exit;
    }
    $_SESSION['prod_id'] = $_GET['prod_id'];
?>
<?php require 'meta.php';?>
<style>
    .form-control{
        color: blue;
    }
    #file-input,#main_file-input{
        display: none;
    }
    #file-label{
        display: block;
        position: relative;
        background-color: #0863c5;
        color: white;
        cursor: pointer;
        width: 300px;
        padding: 18px 0;
        border-radius: 10px;
        text-align: center;
    }
    .images{
        width: 90%;
        border: 5px solid black;
        position: relative;
        margin: auto;
        background: red;
        justify-content: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }
    figure{
        width: 60%;         
    }
    main_figure{
        width: 70%;
    }
    img{
        width: 100px;
    }
    main_figcaption{
        text-align: center;
        font-size: 2.4vmin;
        margin-top: 0.5vmin;
        margin-left: 20px;
    }
    figcaption{
        text-align: center;
        font-size: 2.4vmin;
        margin-top: 0.5vmin;
    }
</style>
<title>Product Edit</title>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
<?php require 'admin-navbar.php';?>
<?php require 'admin-sidebar.php';?>
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <!-- left column -->
            <div class="col-md-12 mt-3">
                <!-- general form elements -->
                <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">แก้ไขข้อมูลสินค้า</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="model/admin-edit_products-db.php" enctype="multipart/form-data" id="myForm">
                <?php require 'model/admin-edit_products-db.php';?>
                    <div class="card-body">
                        <div class="form-group col-md-6">
                            <label for="prod_name">ชื่อสินค้า</label>
                            <input type="text" class="form-control" placeholder="ชื่อสินค้า" name="prod_name" id="prod_name" value="<?= $data->name ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="detail">รายละเอียด</label>
                            <textarea class="form-control" id="detail" name="detail" rows="5" required><?= $data->detail ?></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="search">คำค้นหาอื่นๆสำหรับสินค้า <small class="text-muted">(อย่างเช่น gamer,music,...)</small></label>
                            <input type="text" class="form-control" placeholder="คำค้นหา" name="search" id="search" value="<?= $data->search ?>">
                        </div>

                        <div class="row">
                            <div class="col-md-10 mb-3">
                                <select class="form-control w-50" name="type_shirt" id="type_shirt">
                                    <option value="<?=$category?>"><?=$category?></option>
                                    <option value="เสื้อผู้ชาย">เสื้อผู้ชาย</option>
                                    <option value="เสื้อผู้หญิง">เสื้อผู้หญิง</option>
                                    <option value="เสื้อเด็กผู้ชาย">เสื้อเด็กผู้ชาย</option>
                                    <option value="เสื้อเด็กผู้หญิง">เสื้อเด็กผู้หญิง</option>
                                </select>
                            </div>
                            <div class="col-md-10">
                                <div class="btn-group-sm btn-sm" role="group" aria-label="Basic checkbox toggle button group">  
                                    <?php                                       
                                        if($category_shirt == "เสื้อผ้า"){
                                            echo "<h6 class=\"text-start h-6\">ไซส์เสื้อ</h6>";
                                            $checked_shirt = "";
                                            $shirt_size_ori = array("S","M","L","XL","XXL","3XL","4XL","5XL");
                                            for($i=0;$i<count($shirt_size_ori);$i++){
                                                if(in_array($shirt_size_ori[$i], $shirt_size)){
                                                    $checked_shirt = "checked";
                                                }else{
                                                    $checked_shirt = "";
                                                }
                                                echo "<input type=\"checkbox\" class=\"btn-check btnshirt\" value=\"$shirt_size_ori[$i]\" name=\"btnshirt[]\" id=\"btnshirt$i\" autocomplete=\"off\" $checked_shirt>
                                                    <label class=\"btn btn-outline-primary\" for=\"btnshirt$i\">$shirt_size_ori[$i]</label>";
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                            <div class="btn-group-sm btn-sm" role="group" aria-label="Basic checkbox toggle button group">  
                                    <?php
                                        echo "<h6 class=\"text-start\">สี</h6>";
                                        $checked_colors = "";
                                        $colors_ori = array("ม่วง","น้ำเงิน","น้ำตาล","ส้ม","แดง","เขียว","เหลือง","ชมพู","ทอง","เงิน","เทา","ขาว","ดำ");
                                        for($i=0;$i<count($colors_ori);$i++){
                                            if(in_array($colors_ori[$i],$colors)){
                                                $checked_colors = "checked";
                                            }else{
                                                $checked_colors = "";
                                            }
                                            echo "<input type=\"checkbox\" class=\"btn-check btncolors\" value=\"$colors_ori[$i]\" name=\"btncolors[]\" id=\"btncolors$i\" autocomplete=\"off\" $checked_colors>
                                                    <label class=\"btn btn-outline-primary\" for=\"btncolors$i\">$colors_ori[$i]</label>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="price">ราคา</label>
                                <input type="number" class="form-control" id="price" placeholder="ราคา" name="price" value="<?= $data->price ?>" min="1" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="remain">คงเหลือ</label>
                                <input type="number" class="form-control" id="remain" placeholder="คงเหลือ" name="remain" value="<?= $data->remain ?>" min="1" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="delivery_cost">ค่าจัดส่ง</label>
                                <input type="number" class="form-control" id="delivery_cost" placeholder="ค่าจัดส่ง" name="delivery_cost" value="<?= $data->delivery_cost ?>" min="1" required>
                            </div>
                        </div>

                        <label>เพิ่มรูปภาพประกอบ</label>
                        <div class="row">
                            <div class="col-lg-8">
                                <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                                <input type="file" id="file-input" name="upfile[]" onchange="preview()" accept="image/png, image/jpg, image/jpeg" multiple>
                                <label for="file-input" id="file-label"><i class="fas fa-image fa-lg"></i>&nbsp;เลือกรูปภาพ</label>
                                <span class="d-block text-danger">***อัพโหลดภาพไม่เกิน 2 MB***</span>
                                <p id="num-of-files" class="d-inline-block">No File Chosen</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div id="images"></div>
                            </div>
                        </div>

        <!--/////////////////////// การแสดงตารางของรูปภาพสินค้า ////////////////////////////-->
                        <div class="row">
                            <div class="col-md-5">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>รูปภาพที่มีอยู่</th>
                                            <th>ลบ</th>
                                        </tr>
                                    <tbody>
                                        
                                            <?php
                                                if(!empty($data->img_file)){
                                                    $img_file_show = explode(",",$data->img_file);
                                                    for($i=0;$i<count($img_file_show);$i++){
                                                        echo <<<php
                                                                <tr>
                                                                    <td><img src="dist/product-img/$id/$img_file_show[$i]" alt="" border=3 height=100 width=300></td>
                                                                    <td><a href="model/admin-delete_img.php?img_file=$img_file_show[$i]&id=$id" class="btn btn-danger">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </a></td>
                                                                </tr>
                                                        php;
                                                    }   
                                                }else{
                                                    echo "<tr><td style=\"color:red;\">ไม่มีรูปภาพ</td></tr>";
                                                }
                                            ?>
                                        </tr>
                                    </tbody>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div> 
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" id="ok" class="btn btn-primary mb-5">แก้ไข</button>
                    </div>
                </form>
                </div>
                <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
    </div>
</div>
</body>
<?php require 'script.php';?>
<script>
    function alert_show(t1, t2){
        Swal.fire({
            icon: t1,
            text: t2,
            confirmButtonColor: '#007bff'
        });
    }

    
    $(document).ready(function() {
        $('#file-input').bind('change', function() {
            var aa = (this.files[0].size);
            var nm = (this.files[0].name);
            if(aa > 2097152) {
                var alt = 'รูปภาพ ' + nm + ' มีขนาดใหญ่เกิน 2 MB';
                alert_show('warning',alt);
            }
        });

        
    });

    let fileInput = document.getElementById('file-input');
    let imageContainer = document.getElementById('images');
    let numOfFiles = document.getElementById('num-of-files');

     // ฟังก์ชั่นสำหรับแสดงรูปภาพ
     function preview(){
        imageContainer.innerHTML = "";
        numOfFiles.textContent = fileInput.files.length + ' Files Selected';
        for(i of fileInput.files){
        let reader = new FileReader();
        let figure = document.createElement('figure');
        let figcap = document.createElement('figcaption');

        figcap.innerHTML = i.name;
        figure.appendChild(figcap);
        reader.onload=()=>{
            let img = document.createElement('img');
            img.setAttribute("src",reader.result);
            figure.insertBefore(img,figcap);
        }
        imageContainer.appendChild(figure);
        reader.readAsDataURL(i);
        }
    }
</script>
<?php require 'footer.php';?>
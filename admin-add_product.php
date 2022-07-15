<?php 
@session_start(); 
if(!isset($_SESSION['admin'])){
    header('location: admin-signin.php');
    exit;
}
?>
<style>
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
        #main_file-label{
          display: block;
          position: relative;
          background-color: #e70707;
          color: white;
          cursor: pointer;
          width: 300px;
          padding: 18px 0;
          border-radius: 10px;
          text-align: center;
        }
        p{
          text-align: center;
          margin: 20px 0 30px 0;
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
        .main_images{
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
<?php require 'meta.php';?>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
<?php require 'admin-navbar.php';?>
<?php require 'admin-sidebar.php';?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <div class="content">
      <div class="container">
          <form method="post" enctype="multipart/form-data" id="myForm" action="model/admin-add_product-db.php">
                <div class="row">
                    <div class="col-12">
                        <div class="card my-3">
                            <div class="card-body">
                                <h5 class="mb-3" style="font-weight: 700;">เพิ่มรายการสินค้า</h5>

                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label for="name_prod">ชื่อสินค้า</label>
                                            <input class="form-control form-control-sm" type="text" id="name_prod" name="name_prod" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-8">
                                        <label for="detail">รายละเอียด</label>
                                        <textarea id="detail" name="detail" class="form-control" rows="8" cols="50" required></textarea>
                                    </div>
                                </div>

                                <div class="row mt-3 mb-3">
                                    <div class="col-lg-8">
                                        <label for="search">คำค้นหาอื่่นๆสำหรับสินค้า <small class="text-muted">(อย่างเช่น gamer,music,...)</small></label>
                                        <input class="form-control form-control-sm" type="text" id="search" name="search">
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col">
                                        <select class="form-control w-75" name="category" id="category" onchange="check_cate();">
                                            <option value="">หมวดหมู่ของสินค้า</option>
                                            <option value="เครื่องใช้ไฟฟ้า">เครื่องใช้ไฟฟ้า</option>
                                            <option value="เสื้อผ้า">เสื้อผ้า</option>
                                            <option value="รองเท้า">รองเท้า</option>
                                            <option value="อุปกรณ์คอมพิวเตอร์">อุปกรณ์คอมพิวเตอร์</option>
                                            <option value="ของใช้เบ็ตเตล็ด">ของใช้เบ็ตเตล็ด</option>
                                            <option value="อาหาร">อาหาร</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- เลือกไซส์และประเภทรองเท้า -->
                                <div class="row my-3" id="shoe">
                                    <div class="col-md-10 mb-2">
                                        <select class="form-control w-50" name="type_shoe" id="type_shoe">
                                            <option value="">ประเภทรองเท้า</option>
                                            <option value="รองเท้าผู้ชาย">รองเท้าผู้ชาย</option>
                                            <option value="รองเท้าผู้หญิง">รองเท้าผู้หญิง</option>
                                            <option value="รองเท้าเด็กผู้ชาย">รองเท้าเด็กผู้ชาย</option>
                                            <option value="รองเท้าเด็กผู้หญิง">รองเท้าเด็กผู้หญิง</option>
                                        </select>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="text-start h-6">ไซส์ UK</p>
                                        <div class="btn-group-sm btn-sm" role="group" aria-label="Basic checkbox toggle button group">  
                                            <?php
                                                $count = 3;
                                                for($i=1;$i<=20;$i++){
                                                    echo "<input type=\"checkbox\" class=\"btn-check btnshoe\" value=\"$count\" name=\"btnshoe[]\" id=\"btnshoe$i\" autocomplete=\"off\">
                                                          <label class=\"btn btn-outline-primary\" for=\"btnshoe$i\">$count</label>";
                                                    $count = $count + 0.5;
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- เลือกไซส์และประเภทรองเท้า -->
                                
                                <!-- เลือกไซส์และประเภทเสื้อ -->
                                <div class="row my-3" id="shirt">
                                    <div class="col-md-10 mb-2">
                                        <select class="form-control w-50" name="type_shirt" id="type_shirt">
                                            <option value="">ประเภทเสื้อ</option>
                                            <option value="เสื้อผู้ชาย">เสื้อผู้ชาย</option>
                                            <option value="เสื้อผู้หญิง">เสื้อผู้หญิง</option>
                                            <option value="เสื้อเด็กผู้ชาย">เสื้อเด็กผู้ชาย</option>
                                            <option value="เสื้อเด็กผู้หญิง">เสื้อเด็กผู้หญิง</option>
                                        </select>
                                    </div>
                                    <div class="col-md-10">
                                        <p class="text-start h-6">ไซส์เสื้อ</p>
                                        <div class="btn-group-sm btn-sm" role="group" aria-label="Basic checkbox toggle button group">  
                                            <?php
                                                $size_shirt = array("S","M","L","XL","XXL","3XL","4XL","5XL");
                                                for($i=0;$i<count($size_shirt);$i++){
                                                    echo "<input type=\"checkbox\" class=\"btn-check btnshirt\" value=\"$size_shirt[$i]\" name=\"btnshirt[]\" id=\"btnshirt$i\" autocomplete=\"off\">
                                                          <label class=\"btn btn-outline-primary\" for=\"btnshirt$i\">$size_shirt[$i]</label>";
                                                }
                                            ?>
                                        </div>
                                    </div>        
                                </div>
                                <!-- เลือกไซส์และประเภทเสื้อ -->
                                
                                <!-- เลือกสี -->
                                <div class="row my-3">
                                    <div class="col-md-8">
                                    <p class="text-start h-6">สี</p>
                                    <div class="btn-group-sm btn-sm" role="group" aria-label="Basic checkbox toggle button group">  
                                            <?php
                                                $colors = array("ม่วง","น้ำเงิน","น้ำตาล","ส้ม","แดง","เขียว","เหลือง","ชมพู","ทอง","เงิน","เทา","ขาว","ดำ");
                                                for($i=0;$i<count($colors);$i++){
                                                    echo "<input type=\"checkbox\" class=\"btn-check btncolors\" value=\"$colors[$i]\" name=\"btncolors[]\" id=\"btncolors$i\" autocomplete=\"off\">
                                                          <label class=\"btn btn-outline-primary\" for=\"btncolors$i\">$colors[$i]</label>";
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- เลือกสี -->

                                <div class="row my-3">
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="price">ราคา</label>
                                            <input class="form-control form-control-sm" type="text" name="price" id="price" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="invent">คงเหลือ</label>
                                            <input class="form-control form-control-sm" type="text" name="invent" id="invent" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12">
                                        <div class="form-group">
                                            <label for="shipp_cost">ค่าจัดส่ง</label>
                                            <input class="form-control form-control-sm" type="text" name="shipp_cost" id="shipp_cost" required>
                                        </div>
                                    </div>
                                </div> 

                                <label>เพิ่มรูปภาพแสดงหลัก</label>
                                    <div class="row mb-3">
                                        <div class="col-lg-8">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                                            <input type="file" id="main_file-input" name="main_file" onchange="main_preview()" accept="image/png, image/jpg, image/jpeg" required>
                                            <label for="main_file-input" id="main_file-label"><i class="far fa-image fa-lg"></i>&nbsp;เลือกรูปภาพ</label>
                                            <span class="d-block text-danger">***อัพโหลดภาพไม่เกิน 2 MB***</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div id="main_images" class="mb-3"></div>
                                        </div>
                                    </div>
                                <label>เพิ่มรูปภาพประกอบ</label>
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <input type="hidden" name="MAX_FILE_SIZE" value="2097152">
                                            <input type="file" id="file-input" name="upfile[]" onchange="preview()" accept="image/png, image/jpg, image/jpeg" multiple required>
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
                                <button class="btn btn-primary mt-2 mb-4" type="button" id="ok" name="ok">อัพโหลด</button>
                            </div>
                        </div>
                    </div>
                </div>
          </form>
          

            </div>
        </div>
    </div>
</div>
<div class="mt-2"></div>
</body>

<?php require 'script.php';?>
<script>

     // ซ่อนไซส์รองเท้าก่อนใช้ selected เลือก
     var shoe = document.getElementById('shoe');
    shoe.style.display = "none";
    let check_shoe = false;

    // ซ่อนไซส์เสื้อก่อนใช้ selected เลือก
    var shirt = document.getElementById('shirt');
    shirt.style.display = "none";
    let check_shirt = false;

    // check category
    function check_cate(){
        var c = document.getElementById('category');
        var displaytext = c.options[c.selectedIndex].text;
        if(displaytext == 'รองเท้า'){
            shoe.style.display = "block";
            check_shoe = true;
            check_shirt = false;
            shirt.style.display = "none";
        }else if(displaytext == 'เสื้อผ้า'){
            shoe.style.display = "none";
            check_shirt = true;
            check_shoe = false;
            shirt.style.display = "block";
        }else{
            shoe.style.display = "none";
            shirt.style.display = "none";
        }
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

        $('#main_file-input').bind('change', function() {
            var a = (this.files[0].size);
            var n = (this.files[0].name);
            if(a > 2097152) {
                var nn = 'รูปภาพ ' + n + ' มีขนาดใหญ่เกิน 2 MB';
                alert_show('warning',nn);
            }
        });


        $('#ok').click(function(){
            var price = $('#price').val();
            var invent = $('#invent').val();
            var shipp_cost = $('#shipp_cost').val();       
            var name_prod = $('#name_prod').val();       
            var detail = $('#detail').val(); 
            var category = $('#category').val(); 
            var type_shoe = $('#type_shoe').val(); 
            var type_shirt = $('#type_shirt').val(); 
            var file_input = $('#file-input').val(); 
            var main_file_input = $('#main_file-input').val();


            // เก็บค่าของสีให้อยู่ในรูป array
            var colors = $('.btncolors:checked').map(function(){
                return this.value;
            }).get();

            var shoe_checkbox = $('.btnshoe:checked').map(function(){
                return this.value;
            }).get();

            var shirt_checkbox = $('.btnshirt:checked').map(function(){
                return this.value;
            }).get();
            

            if(check_shirt == true && type_shirt == ""){
                alert_show('warning','กรุณาเลือกประเภทของเสื้อ');
            }else if(check_shirt == true && shirt_checkbox == ""){
                alert_show('warning','กรุณาเลือกไซส์เสื้อ');
            }else if(check_shoe == true && type_shoe == ""){
                alert_show('warning','กรุณาเลือกประเภทรองเท้า');
            }else if(check_shoe == true && shoe_checkbox == ""){
                alert_show('warning','กรุณาเลือกไซส์รองเท้า');
            }else if($.isNumeric(price) === false){
                alert_show('warning','กรุณากรอกราคาให้เป็นตัวเลข');
            }else if($.isNumeric(invent) === false){
                alert_show('warning','กรุณากรอกค่าคงเหลือให้เป็นตัวเลข');
            }else if($.isNumeric(shipp_cost) === false){
                alert_show('warning','กรุณากรอกค่าจัดส่งให้เป็นตัวเลข');
            }else if(category == ""){
                alert_show('info','กรุณาเลือกหมวดหมู่ของสินค้า');
            }else if(file_input == "" || main_file_input == ""){
                alert_show('info','กรุณาอัปโหลดรูปภาพให้ครบถ้วน');
            }else if(name_prod == "" || detail == "" || price == ""
                    || invent == "" || shipp_cost == ""){
                alert_show('info','กรุณากรอกข้อมูลให้ครบถ้วน');
            }else {
                Swal.fire({
                  position: 'top-center',
                  icon: 'success',
                  title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                  showConfirmButton: false,
                  timer: 1500
              });
              setTimeout(function(){
                $('#myForm').submit()
              }, 1000);
            }
        });

        function alert_show(t1, t2){
          Swal.fire({
              icon: t1,
              text: t2,
              confirmButtonColor: '#007bff'
          });
        }
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

    let main_fileInput = document.getElementById('main_file-input');
    let main_imageContainer = document.getElementById('main_images');

    function main_preview(){
        main_imageContainer.innerHTML = "";
        for(i of main_fileInput.files){
        let reader = new FileReader();
        let figure = document.createElement('main_figure');
        let figcap = document.createElement('main_figcaption');

        figcap.innerHTML = i.name;
        figure.appendChild(figcap);
        reader.onload=()=>{
            let img = document.createElement('img');
            img.setAttribute("src",reader.result);
            figure.insertBefore(img,figcap);
        }
        main_imageContainer.appendChild(figure);
        reader.readAsDataURL(i);
        }
    }
</script>
<?php require 'footer.php';?>
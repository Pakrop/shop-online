<?php
    @session_start();
    require 'ConnDB.php';

    $id = $_SESSION['prod_id'];
    $sql = "SELECT * FROM product WHERE id = $id"; 
    $result = $conn->query($sql);
    $data = $result->fetch_object();
    $shoe_size = explode(",",$data->shoe_size);
    $shirt_size = explode(",",$data->shirt_size);
    $colors = explode(",",$data->colors);
    $category = $data->category;
    // ใช้ substr เพื่อใช้ในการค้นหา
    $category_shirt = substr($category,0,24);
    $category_shoe = substr($category,0,21);

    date_default_timezone_set('Asia/Bangkok');
    $date_now = date('Y-m-d H:i:s');

    // ฟังก์ชั่นการบีบอัดรูปภาพ
    function compressImage($source, $destination, $quality){
        $imageInfo = getimagesize($source);
        $mime = $imageInfo['mime'];
        switch($mime){
            case 'image/jpeg':
                $image = imagecreatefromjpeg($source);
                break;
            case 'image/png':
                $image = imagecreatefrompng($source);
                break;
            case 'image/jpg':
                $image = imagecreatefromgif($source);
                break;
            default:
                $image = imagecreatefromjpeg($source);
        }  
        // save image
        imagejpeg($image, $destination, $quality);
        return $destination;
    }

    // สร้างตัวแปรแอเรย์ที่ว่างเอาไว้ เพื่อเอาไปเก็บรายชื่อรูปภาพ
    $img_files = [];

    if(strpos($data->img_file,",")){
        $img_file_data = explode(",",$data->img_file);
        $img_file_count = count($img_file_data);
    }else{
        $img_file_data = null;
        $img_file_count = 0;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['prod_name'];
        $detail = $_POST['detail'];
        $search = !empty($_POST['search'])?$_POST['search']:null;
        if(!empty($_POST['btnshoe'])){
            $shoe_size = implode(",",$_POST['btnshoe']);
            $shoe_size = preg_replace('/,+/', ',', rtrim($shoe_size, ',')); 
            $shoe_size = ltrim($shoe_size, ','); 
        }else{$shoe_size = null;}

        if(!empty($_POST['btnshirt'])){
            $shirt_size = implode(",",$_POST['btnshirt']);
            $shirt_size = preg_replace('/,+/', ',', rtrim($shirt_size, ','));
            $shirt_size = ltrim($shirt_size, ','); 
        }else{$shirt_size = null;}

        if(!empty($_POST['btncolors'])){
            $colors = implode(",",$_POST['btncolors']);
            $colors = preg_replace('/,+/', ',', rtrim($colors, ','));
            $colors = ltrim($colors, ','); 
        }else{$colors = null;}

        $price = $_POST['price'];
        $remain = $_POST['remain'];
        $delivery_cost = $_POST['delivery_cost'];

        //insert ไฟล์รูปภาพเพิ่มเติม /////////////////////////////////////////////////////////////////////////////

        // นับจำนวนไฟล์รูปภาพที่อัพโหลดมา
        $count_upload = count($_FILES['upfile']['name']);

        //  ตรวจสอบรูปภาพจากการใช้ลูป
        for($i=0;$i<$count_upload;$i++){
            $file = $_FILES['upfile']['tmp_name'][$i];
            $name = $_FILES['upfile']['name'][$i];
    
            $uploadPath = "../dist/product-img/".$id."/";

            $countFirstImg = substr($data->img_file,-6);
            $countFirstImg = ltrim($countFirstImg,'-');
            $countFirstImg = (int)$countFirstImg;

            if(strpos($data->img_file,",")){
                $img_file_data = explode(",",$data->img_file);
                $img_file_count = count($img_file_data);
            }else if(empty($data->img_file)){
                $img_file_data = null;
                $img_file_count = 0;
            }else{
                $img_file_data = $data->img_file;
                $img_file_count = 1;
            }

            if(!empty($name)){
                $fileName = basename($name);
                $type = substr($fileName,-4);
                if($img_file_count != 0){
                    $j = $countFirstImg+$i+1;
                }else{
                    $j = $i+1;
                }
                $newName = $id.'-'.$j.$type;
                $imageUploadPath = $uploadPath . $newName;
                $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
                // allow certain file formats
                $allowTypes = array('jpg', 'png', 'jpeg');
                if(in_array($fileType, $allowTypes)){
                    // Compress size and upload image
                    $compressedImage = compressImage($file, $imageUploadPath, 75);
                    if($compressedImage){
                        $compressedImageSize = filesize($compressedImage);
                        $img_files[] = $newName;
                        $img_file = implode(',',$img_files);
                        $img_file_new = $data->img_file.",".$img_file;
                        $img_file_new = preg_replace('/,+/', ',', rtrim($img_file_new, ','));
                        $img_file_new = ltrim($img_file_new, ',');
                    }else{
                        $_SESSION['check_status'] = 3;
                        header('location: validate.php');
                        exit;
                    }
                }else{
                    $_SESSION['check_status'] = 4;
                    header('location: validate.php');
                    exit;
                }
            }else{
                if(!empty($_FILES['upfile'])){
                    $_SESSION['check_status'] = 2;
                    $_SESSION['upfile'] = $_FILES['upfile']['name'][$i];
                    header('location: validate.php');
                    exit;
                }else{
                    header('location: ../admin-edit_products.php');
                    exit;
                }
            }
        }

        $conn->query("UPDATE product SET detail='$detail', name='$name', search='$search', shoe_size='$shoe_size',
                      shirt_size='$shirt_size', colors='$colors', category='$category', price=$price, remain=$remain, 
                      delivery_cost=$delivery_cost, img_file='$img_file_new', last_edit='$date_now' ");
        $conn->close();
    }                       
?>
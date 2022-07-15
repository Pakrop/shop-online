<?php
  @session_start();
  require '../meta.php';
  require 'ConnDB.php';
  if($_SERVER['REQUEST_METHOD'] == 'POST'){  
    $id = 0;
    $name = $_POST['name_prod'];
    $detail = $_POST['detail'];
    $search = !empty($_POST['search'])?$_POST['search']:null;
    if(!empty($_POST['btnshoe'])){
        $shoe_size = $_POST['btnshoe'];
        $shoe_size = implode(",",$_POST['btnshoe']);
    }else{
        $shoe_size = null;
    }

    if(!empty($_POST['btnshirt'])){
        $shirt_size = $_POST['btnshirt'];
        $shirt_size = implode(",",$_POST['btnshirt']);
    }else{
        $shirt_size = null;
    }

    if(!empty($_POST['btncolors'])){
        $colors = $_POST['btncolors'];
        $colors = implode(",",$_POST['btncolors']);
    }else{
        $colors = null;
    }
    
    $price = $_POST['price'];
    $remain = $_POST['invent'];
    $delivery_cost = $_POST['shipp_cost'];
    $category = $_POST['category'];
    if(isset($_POST['type_shoe']) && isset($_POST['btnshoe'])){
        $category.=','.$_POST['type_shoe'];
    }else if(isset($_POST['type_shirt']) && isset($_POST['btnshirt'])){
        $category.=','.$_POST['type_shirt'];
    }

    // นับจำนวนไฟล์รูปภาพที่อัพโหลดมา
    $count_upload = count($_FILES['upfile']['name']);

    // ตรวจสอบไฟล์ภาพแสดงหลักที่อัพโหลด
    if($_FILES['main_file']['error'] == 2){
        $_SESSION['check_status'] = 1;
        $_SESSION['check_name'] = $_FILES['main_file']['name'];
        header('location: validate.php');
        exit;
    }else if($_FILES['main_file']['error'] > 2){
        $_SESSION['check_status'] = 2;
        header('location: validate.php');
        exit;
    }

    // ตรวจสอบไฟล์ภาพแสดงประกอบที่อัพโหลด
    for($p=0;$p<$count_upload;$p++){
        $err = $_FILES['upfile']['error'][$p];
        if($err == 2){
            $_SESSION['check_status'] = 1;
            $_SESSION['check_name'] = $_FILES['upfile']['name'][$p];
            header('location: validate.php');
            exit;
        }else if($err > 2){
            $_SESSION['check_status'] = 2;
            header('location: validate.php');
            exit;
        }
    }

    date_default_timezone_set('Asia/Bangkok');
    $date_now = date('Y-m-d H:i:s');

    $sql = "INSERT INTO product (id, name, detail, search, shoe_size, shirt_size, colors, category, price, remain, delivery_cost, created) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $conn->stmt_init();
    $stmt->prepare($sql);
    $p = [$id, $name, $detail, $search, $shoe_size, $shirt_size, $colors, $category, $price, $remain, $delivery_cost, $date_now];
    $stmt->bind_param('isssssssiiis', ...$p);
    $stmt->execute();
    $insert_id = $conn->insert_id;
        
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

    //   สร้างโฟลเดอร์เพื่อมาเก็บรูปภาพตามแต่ละไอดี
    @mkdir("../dist/product-img/".$insert_id);
    $uploadPaths = "../dist/product-img/".$insert_id."/";

    // ทำก่ารตรวจสอบและเปลี่ยนชื่อไฟล์ภาพหลักแล้วเรียกใช้ฟังก์ชั่นบีบอัดรูปภาพ
    if(!empty($_FILES['main_file']['name'])){
        $fileName = basename($_FILES['main_file']['name']);
        $newName = 'main' .'-'. $insert_id.$type;
        $imageUploadPath = $uploadPaths . $newName;
        $fileType = pathinfo($imageUploadPath, PATHINFO_EXTENSION);
        // allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg');
        if(in_array($fileType, $allowTypes)){
            // Compress size and upload image
            $compressedImage = compressImage($_FILES['main_file']['tmp_name'], $imageUploadPath, 75);
            if($compressedImage){
                $compressedImageSize = filesize($compressedImage);
                $sql = "UPDATE product SET main_img = '$newName' WHERE id = '$insert_id' ";
                $conn->query($sql);
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
        $_SESSION['check_status'] = 2;
        header('location: validate.php');
        exit;
      }

    //  ตรวจสอบรูปภาพจากการใช้ลูป
    for($i=0;$i<$count_upload;$i++){
        $file = $_FILES['upfile']['tmp_name'][$i];
        $name = $_FILES['upfile']['name'][$i];
  
      $uploadPath = "../dist/product-img/".$insert_id."/";

        if(!empty($name)){
          $fileName = basename($name);
          $type = substr($fileName,-4); 
          $j = $i + 1;
          $newName = $insert_id.'-'.$j.$type;
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
                  $sql = "UPDATE product SET img_file = '$img_file' WHERE id = '$insert_id' ";
                  $conn->query($sql);
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
          $_SESSION['check_status'] = 2;
          header('location: validate.php');
          exit;
        }
    }
    header('location: ../admin-add_product.php');
    exit;
  }

?>

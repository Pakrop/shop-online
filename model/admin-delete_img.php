<?php
    require 'ConnDB.php';
    $img = $_GET['img_file'];
    $id = $_GET['id'];

    // ลบไฟล์รูป
    unlink("../dist/product-img/$id/$img");
    
    date_default_timezone_set('Asia/Bangkok');
    $date_now = date('Y-m-d H:i:s');

    // ลบข้อมูลในฐานข้อมูล
    $result = $conn->query("SELECT img_file FROM product WHERE id = $id");
    $data = $result->fetch_object();
    if(strpos($data->img_file,",")){
        $img_file = explode(",",$data->img_file);
    }else{
        $img_file = $data->img_file;
    }

    if(gettype($img_file) === 'array'){
        for($i=0;$i<count($img_file);$i++){
            if($img == $img_file[$i]){
                $img_file[$i] = "";
            }
        }

        $img_file = implode(",",$img_file);
        $img_file = preg_replace('/,+/', ',', rtrim($img_file, ','));
        $img_file = ltrim($img_file, ',');
    }else if(gettype($img_file) === 'string'){
        $img_file = null;
    }

    $sql = "UPDATE product SET img_file = ?, last_edit = ? WHERE id = ?";
    $stmt = $conn->stmt_init();
    $stmt->prepare($sql);    
    $stmt->bind_param('ssi',$img_file,$date_now,$id);
    $stmt->execute();
?>
<script>
    window.history.back(-1);
</script>
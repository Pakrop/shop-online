<?php
    require 'ConnDB.php';
    if(isset($_POST['prod_check'])){
      $prod = $_POST['prod'];
      $sql = "SELECT * FROM product WHERE name = '$prod'";
      $result = $conn->query($sql);
      $num_rows = $result->num_rows;
      if($num_rows > 0){
        echo 'taken';
      }else{
        echo 'not_taken';
      }
    }
    
?>
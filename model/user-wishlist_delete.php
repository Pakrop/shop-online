<?php
    require "ConnDB.php"; 
    if(!empty($_GET["prod_id"]))
    { 
        $PID = $_GET["prod_id"];
        // echo $PID;  
        $sql = " DELETE FROM wishlist WHERE prod_id = $PID "; 
        $conn->query($sql);
        //echo $sql; 
    } 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="0.1;url=../user-wishlist.php">
    <title>Delete Wishlist</title>
</head>
<body>
</body>
</html>
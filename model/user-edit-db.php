<?php
    require 'ConnDB.php';
    $id = $_SESSION['user_id'];
    $sql = "SELECT * FROM users WHERE id = $id"; 
    $result = $conn->query($sql);
    $data = $result->fetch_object();
    date_default_timezone_set('Asia/Bangkok');
    $date_now = date('Y-m-d H:i:s');
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $pswd = $_POST['pswd'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $sql = "UPDATE users SET email = ?, password = ?, first_name = ?, 
                last_name = ?, address = ?, phone = ?, updated = ? WHERE id = ?";
        $stmt = $conn->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('sssssssi', $email,$pswd,$fname,$lname,$address,$phone,$date_now,$id);
        $stmt->execute();
        $conn->close();
    }                       
?>
<?php
require 'ConnDB.php';
if(isset($_POST['email_check'])){
  $email_state = $_POST['email_keyup'];
  $sql = "SELECT * FROM users WHERE email = '$email_state'";
  $result = $conn->query($sql);
  $num_rows = $result->num_rows;
  if($num_rows > 0){
    echo 'taken';
  }else{
    echo 'not_taken';
  }
}

if(isset($_POST['pswd_check'])){
    $pswd_state = $_POST['pswd_keyup'];
    $sql = "SELECT * FROM users WHERE password = '$pswd_state'";
    $result = $conn->query($sql);
    $num_rows = $result->num_rows;
    if($num_rows > 0){
     echo 'taken';
    }else{
      echo 'not_taken';
    }
  }
?>
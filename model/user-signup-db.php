<?php
    @session_start();
    require 'ConnDB.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){           
      $email = $conn->real_escape_string($_POST['email']);
      $pswd = $conn->real_escape_string($_POST['pswd']);
      $fname = $conn->real_escape_string($_POST['fname']);
      $lname = $conn->real_escape_string($_POST['lname']);
      $address = $conn->real_escape_string($_POST['address']);
      $phone = $conn->real_escape_string($_POST['phone']);
      // $pswd_hash = password_hash($pswd, PASSWORD_BCRYPT);
      date_default_timezone_set('Asia/Bangkok');
      $date_now = date('Y-m-d H:i:s');

      $sql = 'INSERT INTO users (id, email, password, first_name, last_name, address, phone, created) VALUES (?,?,?,?,?,?,?,?)';
      $stmt = $conn->stmt_init();
      $stmt->prepare($sql);
      $p = [0, $email, $pswd, $fname, $lname, $address, $phone,$date_now];
      $stmt->bind_param('isssssss', ...$p);
      $stmt->execute();
      
      $err = $stmt->error;
      $aff_row = $stmt->affected_rows;
      $insert_id = $conn->insert_id;
      $stmt->close();
      $conn->close();

      if ($err || $aff_row != 1) {
          $msg = 'การสมัครสมาชิกเกิดข้อผิดพลาด';
          echo <<<html
            <script>
              alert($msg);
            </script>
          html;
          header('location: ../user-signup.php');
          exit;   
      }else{
          $_SESSION['user_id'] = $insert_id;
          $_SESSION['user_name'] = $fname.' '.$lname;
          header('location: ../user-list-option.php');
          exit;
      }
   }
?>            
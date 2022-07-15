<?php
    @session_start();
    require 'ConnDB.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $conn->real_escape_string($_POST['email']);
        $pswd = $conn->real_escape_string($_POST['pswd']);
        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $stmt = $conn->stmt_init();
        $stmt->prepare($sql);
        $stmt->bind_param('ss',$email,$pswd);
        $stmt->execute();
        $result = $stmt->get_result();
        $num_row = $result->num_rows;
                                                
        if($num_row == 1){
            $data = $result->fetch_object(); 
            $_SESSION['user_id'] = $data->id;
            $name = $data->first_name. ' ' .$data->last_name;
            $_SESSION['user_name'] = $name;
            if(!empty($_POST['remember'])){
                setcookie('user_email',$email,time() + (7 * 24 * 60 * 60));
                setcookie('user_password',$pswd,time() + (7 * 24 * 60 * 60));
            }else{
                setcookie('user_email',null,time() - 3600);
                setcookie('user_password',null,time() - 3600);
            }
            $conn->close();
            header('location: user-list-option.php');
            exit;
        }else if ($num_row == 0){
            header('location: user-signin.php');
            exit;
        }
        
    }
?>    
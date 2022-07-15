<?php
    @session_start();
    if(isset($_SESSION['user_id'])){
        header('location: signout.php');
        exit;
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $_SESSION['admin'] = $_POST['admin'];
        if(!empty($_POST['remember'])){
            setcookie('user_admin',$_POST['admin'],time() + (7 * 24 * 60 * 60));
            setcookie('user_password_admin',$_POST['pswd_admin'],time() + (7 * 24 * 60 * 60));
        }else{
            setcookie('user_admin',null,time() - 3600);
            setcookie('user_password_admin',null,time() - 3600);
        }
        header('location: admin-dashboard.php');
        exit;
    }
?>
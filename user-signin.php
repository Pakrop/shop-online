<?php 
@session_start(); 
if(isset($_SESSION['user_id'])){
    header('location: user-list-option.php');
    exit;
}
?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Bungee&display=swap');
#title{
    font-family: 'Bungee', cursive;
}
</style>
<?php require 'meta.php';?>
<?php require 'navbar.php';?>
<?php require 'model/user-signin-db.php';?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
                <div class="card card-outline card-primary shadow mt-5">
                    <div class="card-header text-center text-primary">
                        <a href="#" class="h1" id="title">eazy-store</a>
                    </div>
                    <div class="card-body">
                        <form method="post" id="loginForm">
                            <h4 class="text-center my-3"><span><i class="fas fa-user fa-3x"></i></span></h4>
                            <h4 class="text-center my-3">เข้าสู่ระบบสมาชิก</h4>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="อีเมลล์" name="email" id="email" value="<?php if(isset($_COOKIE['user_email'])){ echo($_COOKIE['user_email']);} ?>" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-envelope"></span>
                                        </div>
                                    </div>
                            </div>
                            <div class="input-group mb-3"> 
                                <input type="password" class="form-control" placeholder="รหัสผ่าน" name="pswd" id="pswd" value="<?php if(isset($_COOKIE['user_password'])){ echo($_COOKIE['user_password']);} ?>" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="show_pswd" onclick="myFunction()">
                                        <label for="show_pswd">
                                            แสดงรหัสผ่าน
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE['user_password'])){?> checked <?php } ?>>
                                        <label for="remember">
                                            Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-6">
                                    <button type="button" name="ok" id="ok" class="btn btn-primary btn-block">เข้าใช้งาน</button>
                                </div>
                                <div class="col-6">
                                    <a type="button" class="btn btn-info btn-block" href="user-signup.php">สมัครสมาชิก</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
</div>

<?php require 'script.php';?>
<script>
    $(function(){
        var email_status = true;
        var pswd_status = true;

        // check email
        $('#email').keyup(function(){
            var email_keyup = $('#email').val();
            $.ajax({
                url: 'model/user-signin-check.php',
                method: 'POST',
                data: {
                    email_check: 1,
                    email_keyup : email_keyup
                },
                success: function(response){
                   if(response == 'taken'){
                       email_status = true;
                   }else if(response == 'not_taken'){
                       email_status = false;
                   }
                }
            });
        });

        // check password
        $('#pswd').keyup(function(){
            var pswd_keyup = $('#pswd').val();
            $.ajax({
                url: 'model/user-signin-check.php',
                method: 'POST',
                data: {
                    pswd_check: 1,
                    pswd_keyup : pswd_keyup
                },
                success: function(response){
                   if(response == 'taken'){
                       pswd_status = true;
                   }else if(response == 'not_taken'){
                       pswd_status = false;
                   }
                }
            });
        });

        $('#ok').click(function(){
            var email = $('#email').val();
            var pswd = $('#pswd').val();

            if(email == '' || pswd == ''){
                alert_show('warning', 'กรุณากรอกอีเมลหรือรหัสผ่านให้ครบถ้วน');
            }else if(email_status == false){
                alert_show('error', 'อีเมลไม่ถูกต้อง');
            }else if(pswd_status == false){
                alert_show('error', 'รหัสผ่านไม่ถูกต้อง');
            }else if(email_status == true && pswd_status == true){
                $('#loginForm').submit();
            }
        });

        function alert_show(t1, t2){
          Swal.fire({
              icon: t1,
              text: t2,
              confirmButtonColor: '#007bff',
          });
        }
    });

    // shown password
    function myFunction() {
        var x = document.getElementById("pswd");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
<?php require 'footer.php';?>
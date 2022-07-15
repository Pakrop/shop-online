<?php @session_start(); ?>
<?php require 'meta.php'?>
<?php require 'navbar.php'?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card card-outline card-info shadow mt-5">
                <div class="card-header text-center text-info">
                    <a href="#" class="h1" style="font-family: 'Bungee', cursive;">eazy-store</a>
                </div>
                <div class="card-body">
                    <form method="post" id="adminLogin">
                    <?php require 'model/admin-signin-db.php';?>
                        <h4 class="text-center my-3"><span><i class="fas fa-user-cog fa-3x"></i></span></h4>
                        <h4 class="text-center my-3">เข้าสู่ระบบผู้ดูแลระบบ</h4>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ชื่อผู้ใช้" name="admin" id="admin" value="<?php if(isset($_COOKIE['user_admin'])){ echo($_COOKIE['user_admin']);} ?>" required>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user-cog"></span>
                                    </div>
                                </div>
                        </div>
                        <div class="input-group mb-3"> 
                            <input type="password" class="form-control" placeholder="รหัสผ่าน" name="pswd_admin" id="pswd" value="<?php if(isset($_COOKIE['user_password_admin'])){ echo($_COOKIE['user_password_admin']);} ?>" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE['user_password_admin'])){?> checked <?php } ?>>
                                    <label for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <button type="button" id="ok" class="btn btn-info btn-block">ลงชื่อเข้าใช้</button>
                            </div>                    
                        </div>                    
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php require 'script.php'?>
<script>
    $(function(){
        $('#ok').click(function(){
            var admin = $('#admin').val();
            var pswd_admin = $('#pswd_admin').val();

            if(admin == "" || pswd_admin == ""){
                alert_show("warning", "กรุณากรอกชื่อผู้ใช้หรือรหัสผ่านให้ครบถ้วน");
            }else if(admin !== "admin" && pswd_admin !== "123456"){
                alert_show("error", "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง");
            }else{
                $('#adminLogin').submit();
            }
        });

        function alert_show(t1, t2){
          Swal.fire({
              icon: t1,
              text: t2,
              confirmButtonColor: '#007bff'
          });
        }
    });
</script>
<?php require 'footer.php'?>
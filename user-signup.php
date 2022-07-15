<?php 
@session_start();
if (isset($_SESSION['user_id'])) {
  header('location: user-list-option.php');
  exit;
}
?>
<?php require 'meta.php';?>
<?php require 'navbar.php';?>
<br><br><br>
<div class="container my-4 mb-5">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card card-secondary shadow">
          <div class="card-header">
            <h3 class="card-title">สมัครสมาชิก</h3>
          </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" id="myForm" action="model/user-signup-db.php">
                <div class="card-body">
                  <div class="form-group">
                    <label for="email">อีเมล&nbsp;&nbsp;&nbsp;<span id="text-alert"></span><span id="text-alert2"></span></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                      </div>
                      <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
                    </div>
                    <span id="check-email"></span>
                  </div>

                  <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                        <div class="form-group">
                        <label for="pswd">รหัสผ่าน</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                          </div>
                          <input type="password" class="form-control" id="pswd" placeholder="Password" name="pswd" required>
                        </div>
                      </div>
                      <input type="checkbox" onclick="myFunction()">&nbsp;แสดงรหัสผ่าน
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                      <div class="form-group">
                        <label for="re_pswd">รหัสผ่านซ้ำ</label>
                        <input type="password" class="form-control" id="re_pswd" placeholder="Re-Password" name="re_pswd" required>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-4">
                    <div class="col-lg-6 col-sm-12 col-md-6">
                      <div class="form-group">
                        <label for="fname">ชื่อจริง</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                          </div>
                          <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 col-sm-12 col-md-6">
                      <div class="form-group">
                        <label for="lanem">นามสกุล</label>
                        <input type="text" class="form-control" id="lanem" name="lname" placeholder="Last Name" required>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="address">ที่อยู่</label>
                    <textarea type="text" class="form-control" placeholder="Address" id="address"name="address" rows="5" cols="50" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="phone">เบอร์โทรศัพท์</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" class="form-control" name="phone" id="phone" maxlength="10" required>
                    </div>
                  </div>

                <div class="card-footer">
                  <button type="button" id="ok" name="ok" class="btn btn-primary">ลงชื่อเข้าใช้</button>
                  <a type="button" href="user-signin.php" class="btn btn-primary">ย้อนกลับ</a>
                </div>
              </form>
            </div>
        </div>
    </div>
</div>

<?php require 'script.php';?>
<script>
     $(function(){
      var status_check_mail = false;
      var email_state = false;
      var pswd_state = false;
      $('#email').keyup(function(){
        var email = $('#email').val();
        var pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
        if(email.match(pattern)){
          $('#text-alert').removeClass('text-danger');
          $('#text-alert').addClass('text-success');
          $('#text-alert').text('อีเมลนี่สามารถใช้ได้');
          $("#text-alert").append('&nbsp;<i class="fas fa-check-circle"></i>');
          status_check_mail = true;
        }else{
          $('#text-alert').removeClass('text-success');
          $('#text-alert').addClass('text-danger');
          $('#text-alert').text('อีเมลนี่ไม่สามารถใช้ได้');
          $("#text-alert").append('&nbsp;<i class="fas fa-times-circle"></i>');
          status_check_mail = false;
        }

        if(email == ''){
          $('#text-alert').text('');
        }else{
          $.ajax({
              url: 'model/user-signup-check.php',
              method: 'POST',
              data: {
                email_check: 1,
                email: email
              },
              success: function(response){
                if(response == 'taken'){
                    email_state = true;
                }else if(response == 'not_taken'){
                    email_state = false;
                }
              }
          });
        }
      });

      $('#pswd').keyup(function(){
          var pswd = $('#pswd').val();
          $.ajax({
             url: 'model/user-signup-check.php',
             method: 'POST',
             data: {
               pswd_check: 1,
               pswd: pswd
             },
             success: function(response){
                if(response == 'taken'){
                    pswd_state = true;
                }else if(response == 'not_taken'){
                    pswd_state = false;
                }
              }
          });
      });

        $('button#ok').click(function(){
            var msg = "";
            var text = "";
            var p1 = $('[name="pswd"]').val().trim();
            var p2 = $('[name="re_pswd"]').val().trim();
            var fname = $('[name="fname"]').val();
            var lname = $('[name="lname"]').val();
            var address = $('[name="address"]').val();
            var phone = $('[name="phone"]').val();
            
            if(email_state == true){
                msg = "warning";
                text = "อีเมลนี่มีผู้ใช้งานแล้ว";
                alert_show(msg, text);
            }else if(pswd_state == true){
                msg = "warning";
                text = "รหัสผ่านนี่มีผู้ใช้งานแล้ว";
                alert_show(msg, text);
            }else if(status_check_mail == false){
                msg = "warning";
                text = "กรุณากรอกอีเมลให้ถูกต้อง";
                alert_show(msg, text);
            }else if(p1 == "" || p2 == ""){
                msg = "info";
                text = "กรุณากรอกรหัสผ่านให้ครบทั้ง 2 ช่อง";
                alert_show(msg, text); 
            }else if(p1 != p2){
                msg = "warning";
                text = "กรุณากรอกรหัสผ่านให้ตรงทั้ง 2 ช่อง";
                alert_show(msg, text); 
            }else if(p1.length < 6){
                msg = "info";
                text = "กรุณากรอกรหัสผ่านอย่างน้อย 6 ตัว";
                alert_show(msg, text); 
            }else if($.isNumeric(phone) === false){
                msg = "warning";
                text = "กรุณากรอกเบอร์โทรให้เป็นตัวเลข";
                alert_show(msg, text);
            }else if(phone.length < 10){
                msg = "warning";
                text = "กรุณากรอกเบอร์โทรให้ครบจำนวน";
                alert_show(msg, text);
            }else if(email == "" || phone == "" || fname == "" ||
                    lname == "" || address == ""){
                msg = "info";
                text = "กรุณากรอกข้อมูลให้ครบถ้วน";
                alert_show(msg, text);
            }else{
              Swal.fire({
                  position: 'top-center',
                  icon: 'success',
                  title: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                  showConfirmButton: false,
                  timer: 1500
              });
              setTimeout(function(){
                $('#myForm').submit()
              }, 1000);
            }
        })

        function alert_show(t1, t2){
          Swal.fire({
              icon: t1,
              text: t2,
              confirmButtonColor: '#007bff',
          });
        }
    });


    // แสดงรหัสผ่าน
    function myFunction() {
        var x = document.getElementById("pswd");
        var x2 = document.getElementById("re_pswd");
        if (x.type === "password" && x2.type === "password") {
            x.type = "text";
            x2.type = "text";
        } else {
            x.type = "password";
            x2.type = "password";
        }
    }
</script>
<?php require 'footer.php';?>

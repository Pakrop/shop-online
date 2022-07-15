<link rel="stylesheet" href="../dist/css/adminlte.min.css">
<?php
@session_start();

function alert_shown($contextual, $msg){
  $previous = "javascript:history.go(-1)";
  if(isset($_SERVER['HTTP_REFERER'])) {
      $previous = $_SERVER['HTTP_REFERER'];
  }
    echo <<<html
      <div class="col">
          <div class="alert alert-$contextual text-center alert-dismissible fade show mt-3 w-75 mx-auto" role="alert">
              $msg&nbsp;<a href="$previous" class="alert-link">ย้อนกลับ</a>
          </div>
      </div>
    html;
}

if(isset($_SESSION['check_status'])){
  $check = $_SESSION['check_status'];
  if(isset($_SESSION['check_name'])){
    $name = $_SESSION['check_name'];
  }
  $contextual = $msg = "";
  if($check == 1){
    $contextual = "warning";
    $msg = "ไม่สามารถอัพโหลดได้เนื่องจากไฟล์ภาพ $name มีขนาดเกิน 2MB";
    alert_shown($contextual, $msg);
  }else if($check == 2){
    $contextual = "danger";
    $msg = "การอัพโหลดไฟล์ภาพเกิดข้อผิดพลาด";
    echo $_SESSION['upfile'];
    alert_shown($contextual, $msg);
  }else if($check == 3){
    $contextual = "danger";
    $msg = "การย่อขนาดไฟล์ภาพเกิดข้อผิดพลาด";
    alert_shown($contextual, $msg);
  }else if($check == 4){
    $contextual = "danger";
    $msg = "นามสกุลไฟล์ไม่ตรงกับที่ต้องการ";
    alert_shown($contextual, $msg);
  }
}
?>
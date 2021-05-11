<?php
error_reporting(0);
$conn = mysqli_connect("localhost", "taimoor", "taiba123$");
$db = mysqli_select_db($conn, "alkhair_opd");

function restrict($user_type = null){
    if(empty($user_type)) die();
    if($user_type      == 'admin') $user_type = 1;
    else if($user_type == 'teacher') $user_type = 2;
    if(!empty($_SESSION['userType']) && $_SESSION['userType'] == $user_type){
      echo "You don't have permissions to access this page, goto back to <a href='opd_entry.php'>Dashboard</a>";
      die();
  }
}
function _die($array){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    die();
}
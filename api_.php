<?php
session_start();
include_once 'connect.php';
if(empty($_SESSION)) die('un-authorized access');

if($_GET['request'] == "siginlog"){
    $res = mysqli_query($conn, "SELECT l.timestamp, l.ip_address, t.teacherName FROM login_log l INNER JOIN teachers t ON l.staff_id = t.teacherID ORDER by id desc");
    $refined = array();
    while ($log = mysqli_fetch_array($res)) {
        $refined[] = $log;
    }
    echo json_encode(array("status" => 200, "data" => $refined));
    die();
}

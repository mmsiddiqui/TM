<?php
session_start();
date_default_timezone_set('Asia/Karachi');
include 'connect.php';
if(!isset($_SESSION['user'])) header("Location: login.php");
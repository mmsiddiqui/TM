<?php
session_start();
include 'connect.php';
if(!isset($_SESSION['user'])) header("Location: login.php");
else header("Location: opd_entry.php");
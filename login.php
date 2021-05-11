<?php
session_start();
include_once 'connect.php';
include_once 'functions_.php';
// if session [user] is not null / if set and admin
if(isset($_SESSION['user']) != "") header("Location: opd_entry.php");
if(isset($_POST['btnlogin'])){
    $reg_id    = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_pass = mysqli_real_escape_string($conn, $_POST['user_pass']);
    $reg_id    = trim($reg_id);
    $user_pass = trim($user_pass);
    $res       = mysqli_query($conn, "SELECT *, 1 as `userType` FROM user WHERE userEmail='{$reg_id}'");
    $row       = mysqli_fetch_array($res);
    $count     = mysqli_num_rows($res);
    if($count > 0 && $row['userPassword'] == md5($user_pass)) {
        $ip_                  = get_client_ip_server();
        $query                = "INSERT INTO login_log(staff_id, ip_address) VALUES ('".$row['userID']."', '".$ip_."')";
        $insert               = mysqli_query($conn, $query);
        $_SESSION['userID']   = $row['userID'];
        $_SESSION['user']     = $row['userEmail'];
        $_SESSION['username'] = $row['userName'];
        $_SESSION['userType'] = $row['userType'];
        header("Location: opd_entry.php");
    }
    else{
        ?>
        <script>alert('Username / Password Seems Wrong !');</script>
        <?php
    }
}
?>
<?php $title = 'Login'; include('head.php')?>
<body>
    <div class="container">
        <form class="form-signin" action="" method="post">
            <center>
                <img src="images/logo.png" class="" alt="logo" style="width: 70%">
            </center>
            <h5 class="form-signin-heading "><center>Login to OPD</center></h5>
            <label for="inputEmail" class="sr-only">Username</label>
            <input type="text" id="user_email" name="user_email" class="form-control" placeholder="Enter Username" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" id="user_pass" name="user_pass" class="form-control" placeholder="Enter Password" required>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnlogin">Sign in</button>
        </form>

        <p class="text-center">Powered by <a href="//taiba.tech">Taiba.Tech</a></p>
    </div> <!-- /container -->
    <?php include('scripts.php')?>
</body>
</html>
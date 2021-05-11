<?php include "logic.php" ?>
<?php
if(!isset($_GET['edit_profile'])) _die("No user found, go back");
$edit_user = null;
$user_id               = $_SESSION['userID'];
$page_title            = "Edit Profile";
$activate_edit_profile = true;

if(!empty($user_id)){
  $edit_user = mysqli_query($conn, "SELECT userID, userName, userEmail, userImagePath FROM user WHERE userID = '{$user_id}'");
  $edit_user = mysqli_fetch_array($edit_user);
  if(empty($edit_user)) _die("No user found with this id, go back");
}
?>
<?php $title = 'Users'; include('head.php')?>
<body>
  <?php include('navbar.php')?>
  <div class="container-fluid extra-padding-top">
    <div class="row">
      <?php include('sidebar.php')?>
      <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
        <br>
        <h1><?php echo $page_title; ?></h1>
        <section class="row text-center placeholders">
          <div class="col-sm-9">
            <?php 
            if(!$activate_edit_profile){
              if(empty($edit_user)){?>
                <h4>Add User</h4>
              <?php } else { ?>
                <h4>Edit User</h4>
              <?php } } ?>
              <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group row">
                  <label for="" class="col-2 col-form-label">User Name</label>
                  <div class="col-10">
                    <input type="text" class="form-control" id="txtUserName" name="txtUserName" placeholder="Enter User Name" readonly="" value="<?php echo $edit_user['userName'];?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="" class="col-2 col-form-label">Email Address</label>
                  <div class="col-10">
                    <input type="email" class="form-control" id="txtEmailAddress" name="txtEmailAddress" placeholder="Enter User Email Address" required="required" value="<?php echo $edit_user['userEmail'];?>" <?php if(!empty($edit_user)) echo "readonly";?>>
                  </div>
                </div>
                <div class="form-group row">
                  <?php if(empty($edit_user)){?>
                    <label for="txtPassword" class="col-2 col-form-label">Password</label>
                    <div class="col-10">
                      <input type="password" class="form-control" id="" name="txtPassword" placeholder="Enter User Default Password" required="">
                    </div>
                  <?php } else {?>
                    <label for="txtNewPassword" class="col-2 col-form-label">New Password</label>
                    <div class="col-10" id="div_new_pass_check">
                      <label for="checkNewPass_yes" class="col-6 col-form-label" id="checkNewPass_yes"><input type="checkbox" name="checkNewPass" value="yes"> Check this to change password</label>
                      <label for="checkNewPass_no" class="col-6 col-form-label" id="checkNewPass_no"><input type="checkbox" name="checkNewPass" value="no"> I don't want to change password</label>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-10" id="div_new_pass">
                      <input type="password" class="form-control" id="txtNewPassword" name="txtNewPassword" placeholder="Enter User New Password">
                    </div>
                  <?php } ?>
                </div>
                <div class="form-group row">
                  <div class="col-12">
                    <?php if(empty($edit_user)){?>
                      <input type="submit" class="form-control btn btn-primary" id="btnAddUser" name="btnSubmitUser" value="Add User">
                    <?php } else { ?>
                      <input type="submit" class="form-control btn btn-primary" id="btnUpdateUser" name="btnSubmitUser" value="Modify User">
                    <?php } ?>
                  </div>
                </div>
              </form>
            </div>
            <?php 
            if (isset($_POST['btnSubmitUser'])) {
              if(isset($_POST['txtUserName']) && isset($_POST['txtEmailAddress'])){
                $add_msg  = "User Added!";
                $fail_msg = "Failed to add User!";
                $password = $_POST['txtPassword'];
                if(!empty($_POST['txtNewPassword'])) $password = $_POST['txtNewPassword'];
                $password = md5($password);
                $user_query = "INSERT INTO `user`(`userID`, `userName`, `userEmail`, `userPassword`, `userImagePath`, `insert_at`) VALUES (
                '',
                '{$_POST['txtUserName']}',
                '{$_POST['txtEmailAddress']}',
                '".$password."',
                '".date('Y-m-d h:m:s')."')";
                if(!empty($edit_user)){
                  $user_query = "UPDATE 
                  `user`
                  SET `userName` = '{$_POST['txtUserName']}',";
                  if(!empty($_POST['txtNewPassword'])) $user_query .= "`userPassword` = '{$password}',";
                  $user_query .= "`update_at` = '".date('Y-m-d h:m:s')."'
                  WHERE `userID` = '{$user_id}';";
                  $add_msg  = "User Modified!";
                  $fail_msg = "Failed to modify User!";
                }
                $userQueryRun = mysqli_query($conn, $user_query);
                if ($userQueryRun) {
                  echo "<script>alert('{$add_msg}');</script>";
                  echo "<script>window.location.href='{$_SERVER['PHP_SELF']}'</script>";
                }
                else echo "<script>alert('{$fail_msg}');</script>";
              }
              else echo "<script>alert('Fill out all the fields');</script>";
            }
            ?>
            <?php if(!$activate_edit_profile){ ?>
              <br><br>
              <div class="col-sm-9">
                <h4>User</h4>
                <table class="table table-bordered">
                  <thead>
                    <tr class="bg-inverse" style="color: white">
                      <th>#</th>
                      <th>Title</th>
                      <th>Email</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $queryUser = "SELECT * from user";
                    $retrieveUser = mysqli_query($conn, $queryUser);
                    $sl = 1;
                    while ($user = mysqli_fetch_array($retrieveUser)) {
                      ?>
                      <tr>
                        <th scope="row"><?php echo $sl; ?></th>
                        <td><?php echo $user['userName']; ?></td>
                        <td><?php echo $user['userEmail']; ?></td>
                        <td>
                          <a href="<?php echo $_SERVER['PHP_SELF']?>?edit_id=<?php echo $user['userID']?>">
                            <i class="fa fa-edit" aria-hidden="true"></i>
                          </a>
                          <a href="<?php echo $_SERVER['PHP_SELF']?>?delete_id=<?php echo $user['userID']?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                          </a>
                        </td>
                      </tr>
                      <?php $sl++; } ?>
                    </tbody>
                  </table>
                  <?php
                  if(isset($_GET['delete_id'])){
                    if(mysqli_query($conn, "DELETE FROM `users` WHERE userID = '{$_GET['delete_id']}'")){
                      echo "<script>alert('User Deleted!');</script>";
                      echo "<script>window.location.href='{$_SERVER['PHP_SELF']}'</script>";
                    }
                    else{
                      echo "<script>alert('Failed to Delete User!');</script>";
                    }
                  }
                  ?>
                </div>
                <?php
              }
              mysqli_close($conn);
              ?>
            </section>
          </main>
        </div>
      </div>
      <?php include('scripts.php')?>
      <script type="text/javascript">
        $(document).ready(function(){
          $("#div_new_pass").hide();
          $("#checkNewPass_no").hide();
          $("#new_profile_pic_div").hide();
          $("[name='checkNewPass']").change(function(){
            if(this.value == 'yes'){
              $("#div_new_pass").show();
              $("#checkNewPass_yes").hide();
              $("#checkNewPass_no").show();
            }
            else if(this.value == 'no'){
              $("#div_new_pass").hide();
              $("#checkNewPass_yes").show();
              $("#checkNewPass_no").hide();
              $("#txtNewPassword").val('');
            }
          });
          $('#delete_pic').click(function(){
            $("#profile_pic_div").hide();
            $("#new_profile_pic_div").show();
          });
        }); 
      </script>
    </body>
    </html>
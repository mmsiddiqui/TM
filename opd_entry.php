<?php include "logic.php" ?>
<?php
$entryID = null;
$edit_title = null;
if(!empty($_GET['edit_id'])){
  $entryID = $_GET['edit_id'];
  $edit_title = "OPD Entry";
}
if(!empty($_SESSION['userType']) && $_SESSION['userType'] == 2){
  $entryID = $_SESSION['userID'];
  $edit_title = "Edit OPD Entry";
}
if(!empty($entryID)){
  $edit_entry = mysqli_query($conn, "SELECT * from opd_entries WHERE entryID = '{$entryID}'");
  $edit_entry = mysqli_fetch_array($edit_entry);
  if(empty($edit_entry)) _die("No entry found with this id, go back");
}
?>
<?php $title = 'OPD ENTRY'; include('head.php')?>
<body>
  <?php include('navbar.php')?>
  <div class="container-fluid extra-padding-top">
    <div class="row">
      <?php include('sidebar.php')?>
      <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
        <br>
        <h1><?php echo $edit_title; ?></h1>
        <section class="row text-center placeholders">
          <div class="col-sm-9">
            <?php 
            if(!empty($_SESSION['userType']) && $_SESSION['userType'] == 1){
              if(empty($edit_entry)){?>
                <h4>Add OPD Entry</h4>
              <?php } else { ?>
                <h4>Edit OPD Entry</h4>
              <?php }
            }?>
            <form action="" method="post" enctype="multipart/form-data">
              <?php if(!empty($edit_entry['entryID'])) { ?>
                <div class="form-group row">
                  <label for="" class="col-2 col-form-label">Serial Number</label>
                  <div class="col-10">
                    <input type="text" class="form-control" name="txtSerial" value="<?php if(!empty($edit_entry['entryID'])) echo $edit_entry['entryID'];?>" readonly>
                  </div>
                </div>
              <?php } ?>
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Patient Title</label>
                <div class="col-10">
                  <select class="form-control" name="drpPatientNameTitle">
                    <option selected="" value="">Select Patient Title</option>
                    <?php
                    $patientTitlesQuery = mysqli_query($conn,"select * from opd_patient_titles where isActive = 1 order by titleName");
                    while ($type = mysqli_fetch_array($patientTitlesQuery)) {
                      ?>
                      <option value="<?php if(!empty($type['titleID']))echo $type['titleID'];?>" <?php if($edit_entry['patientNameTitle'] == $type['titleID']) echo "selected"; ?>><?php echo $type['titleName'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Patient Name</label>
                <div class="col-10">
                  <input type="text" class="form-control" name="txtPatientName" placeholder="Enter Patient Name"  value="<?php if(!empty($edit_entry['patientName']))echo $edit_entry['patientName'];?>" required="">
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Patient Age</label>
                <div class="col-10">
                  <input type="number" min="1" max="100" class="form-control" name="txtPatientAge" placeholder="Enter Patient Age"  value="<?php if(!empty($edit_entry['patientAge']))echo $edit_entry['patientAge'];?>" required="">
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Date</label>
                <div class="col-10">
                  <!-- <input type="date" class="form-control" name="txtopdDate" placeholder="Select Date"  value="<?php if(!empty($edit_entry['opdDate'])) echo $edit_entry['opdDate'];?>" required=""> -->
                  <input type="text" class="form-control" name="txtopdDate" placeholder="Select Date"  value="<?php echo (!empty($edit_entry['opdDate'])) ? $edit_entry['opdDate'] : date('Y-m-d h:i:s') ?>" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">OPD Type</label>
                <div class="col-10">
                  <select class="form-control" name="drpOpdType">
                    <option selected="" value="">Select OPD Type</option>
                    <?php
                    $opdTypesQuery = mysqli_query($conn,"select * from opd_types where isActive = 1 order by typeName");
                    while ($type = mysqli_fetch_array($opdTypesQuery)) {
                      ?>
                      <option value="<?php if(!empty($type['typeID']))echo $type['typeID'];?>" <?php if($edit_entry['opdType'] == $type['typeID']) echo "selected"; ?>><?php echo $type['typeName'];?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Description</label>
                <div class="col-10">
                  <input type="text" class="form-control" name="txtopdDescription" placeholder="Enter Description"  value="<?php if(!empty($edit_entry['opdDescription']))echo $edit_entry['opdDescription'];?>">
                </div>
              </div>
              <div class="form-group row">
                <label for="" class="col-2 col-form-label">Total Amount</label>
                <div class="col-10">
                  <input type="number" min="0" max="9999999" step="any" class="form-control" name="txtopdAmountTotal" placeholder="Enter Total Amount"  value="<?php if(!empty($edit_entry['opdAmountTotal']))echo $edit_entry['opdAmountTotal'];?>" required="">
                </div>
              </div>
              
              <div class="form-group row">
                <div class="col-12">
                  <?php if(empty($edit_entry)){?>
                    <input type="submit" class="form-control btn btn-primary" id="btnAddUser" name="btnSubmitEntry" value="Add OPD Entry">
                  <?php } else { ?>
                    <input type="submit" class="form-control btn btn-primary" id="btnUpdateUser" name="btnSubmitEntry" value="Modify OPD Entry">
                  <?php } ?>
                </div>
              </div>
            </form>
          </div>
          <?php 
          if (isset($_POST['btnSubmitEntry'])) {
            if(isset($_POST['drpPatientNameTitle']) && isset($_POST['txtPatientName']) && isset($_POST['txtPatientAge']) && isset($_POST['txtopdDate']) && isset($_POST['drpOpdType']) && isset($_POST['txtopdAmountTotal'])){
              $add_msg          = "OPD Entry Added!";
              $fail_msg         = "Failed to add OPD Entry!";
              $user_query = "INSERT INTO `opd_entries`(`patientNameTitle`, `patientName`, `patientAge`, `opdDate`, `opdType`, `opdDescription`, `opdAmountTotal`, `createdBy`, `createdAt`) VALUES (
              '{$_POST['drpPatientNameTitle']}',
              '{$_POST['txtPatientName']}',
              '{$_POST['txtPatientAge']}',
              '{$_POST['txtopdDate']}',
              '{$_POST['drpOpdType']}',
              '{$_POST['txtopdDescription']}',
              '{$_POST['txtopdAmountTotal']}',
              '{$_SESSION['userID']}',
              '".date('Y-m-d h:i:s')."')";

              /*if(!empty($edit_entry)){
                $user_query = "UPDATE 
                `opd_entries`
                SET `patientName` = '{$_POST['txtPatientName']}',";
                if(!empty($_POST['txtNewPassword'])) $user_query .= "`teacherPassword` = '{$password}',";
                $user_query .= "
                `departmentID` = '".$_POST['drpDeptName']."',
                `teacherDescription`= '".$_POST['txtTeacherDescription']."',
                `update_at` = '".date('Y-m-d h:m:s')."'
                WHERE `entryID` = '{$entryID}';";
                $add_msg  = "Faculty Modified!";
                $fail_msg = "Failed to modify Faculty!";
              }*/

              $userQueryRun = mysqli_query($conn, $user_query);
              if ($userQueryRun) {
                echo "<script>alert('{$add_msg}');</script>";
                echo "<script>window.location.href='opd_entry_print.php?entry_id=".mysqli_insert_id($conn)."'</script>";
              }
              else echo "<script>alert('{$fail_msg}');</script>";
            }
            else echo "<script>alert('Fill out all the fields');</script>";
          }
          ?>
        </section>
      </main>
    </div>
  </div>
  <?php include('scripts.php')?>
</body>
</html>
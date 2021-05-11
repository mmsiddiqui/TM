<?php include "logic.php" ?>
<?php $title = 'OPD ENTRIES'; include('head.php')?>
<body>
  <?php include('navbar.php')?>
  <div class="container-fluid extra-padding-top">
    <div class="row">
      <?php include('sidebar.php')?>
      <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
        <?php if(!empty($_SESSION['userType']) && $_SESSION['userType'] == 1){ ?>
          <br>
          <div class="col-sm-9">
            <h4>OPD Entries</h4>
            <table class="display" id="table">
              <thead>
                <tr class="bg-inverse" style="color: white">
                  <th>Serial #</th>
                  <th>Patient Name</th>
                  <th>Age</th>
                  <th>OPD Type</th>
                  <th>Description</th>
                  <th>Date</th>
                  <th>Total Amount</th>
                  <th>Added By</th>
                  <th>Added On</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $queryEntry = "SELECT o.*, t.`typeName`, u.`userName`, ot.`titleName` FROM opd_entries o INNER JOIN `opd_types` t ON o.`opdType` = t.`typeID` INNER JOIN `user` u ON o.`createdBy` = u.`userID` INNER JOIN `opd_patient_titles` ot ON o.`patientNameTitle` = ot.`titleID`;";
                $retrieveEntry = mysqli_query($conn, $queryEntry);
                while ($entry = mysqli_fetch_array($retrieveEntry)) {
                  ?>
                  <tr>
                    <th scope="row"><?php echo $entry['entryID']; ?></th>
                    <td><?php echo $entry['titleName'] . ' '.$entry['patientName']; ?></td>
                    <td><?php echo $entry['patientAge']; ?></td>
                    <td><?php echo $entry['typeName']; ?></td>
                    <td><?php echo $entry['opdDescription']; ?></td>
                    <td><?php echo $entry['opdDate']; ?></td>
                    <td>Rs. <?php echo $entry['opdAmountTotal']; ?> /-</td>
                    <td><?php echo $entry['userName']; ?></td>
                    <td><?php echo $entry['createdAt']; ?></td>
                    <td>
                      <a href="opd_entry_print.php?entry_id=<?php echo $entry['entryID']?>">
                        <i class="fa fa-print" aria-hidden="true"></i>
                      </a>
                      <!-- <a href="opd_entry.php?edit_id=<?php echo $entry['entryID']?>">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                      </a> -->
                      <a href="<?php echo $_SERVER['PHP_SELF']?>?delete_id=<?php echo $entry['entryID']?>">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <?php
            if(isset($_GET['delete_id'])){
              if(mysqli_query($conn, "DELETE FROM `opd_entries` WHERE entryID = '{$_GET['delete_id']}'")){
                echo "<script>alert('OPD Entry Deleted!');</script>";
                echo "<script>window.location.href='{$_SERVER['PHP_SELF']}'</script>";
              }
              else{
                echo "<script>alert('Failed to Delete OPD Entry!');</script>";
              }
            }
            ?>
          </div>
        <?php }
        mysqli_close($conn);
        ?>
      </section>
    </main>
  </div>
</div>
<?php include('scripts.php')?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#table').DataTable();
  } );
</script>
</body>
</html>
<nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar extra-padding-top"><br>
  <ul class="nav nav-pills flex-column buttons">
    <li class="nav-item">
      <?php
      $page_name = "OPD Entry";
      if(!empty($_SESSION['userType']) && $_SESSION['userType'] == 2) $page_name = "Edit OPD Entry";
      ?>
      <a class="nav-link sidebars" style="cursor: pointer;" href="opd_entry.php"><img src="images/icons/document.png"><?php echo $page_name; ?></a>
    </li>
    <li class="nav-item">
      <?php
      $page_name = "OPD Entries";
      if(!empty($_SESSION['userType']) && $_SESSION['userType'] == 2) $page_name = "Edit OPD Entries";
      ?>
      <a class="nav-link sidebars" style="cursor: pointer;" href="opd_entries.php"><img src="images/icons/department.png"><?php echo $page_name; ?></a>
    </li>
  </ul>
</nav>
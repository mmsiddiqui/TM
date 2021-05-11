<nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <a class="navbar-brand" href="opd_entry.php"><img src="images/logo.png" style="width: 16%"> Al-Khair General Hospital OPD</a>
  <div class="collapse navbar-collapse" id="navbarCollapse">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="logout.php?logout">Logout</a>
      </li>
      <li class="nav-item">
        <?php
        $page_link = "users.php?edit_profile";
        if(!empty($_SESSION['userType']) && $_SESSION['userType'] == 2) $page_link = "opd_entry.php";
        ?>
        <a class="nav-link" href="<?php echo $page_link;?>"><?php echo $_SESSION['username']; ?></a>
      </li>
    </ul>
  </div>
</nav>
<?php include "logic.php" ?>
<?php 
$title = 'Dashboard';
include('head.php');
include('functions_.php');
$isAdmin = false;
if(getUserType() == 1) $isAdmin = true;
?>
<body>
  <?php include('navbar.php')?>
  <div class="container-fluid extra-padding-top">
    <div class="row">
      <?php include('sidebar.php')?>
      <main role="main" class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
          <br>
          <h1 class="h2">Dashboard</h1>
          <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group mr-2">
              <button class="btn btn-sm btn-outline-secondary">Share</button>
              <button class="btn btn-sm btn-outline-secondary">Export</button>
            </div>
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
              <span data-feather="calendar"></span>
              This week
            </button>
          </div>
        </div>
        <canvas class="my-4" id="myChart" width="900" height="380"></canvas>
        <?php if($isAdmin) { ?>
          <h2>Faculty's Activity</h2>
          <div class="table-responsive">
            <table class="table table-striped table-sm" id="log-table">
              <thead>
                <tr>
                  <th>#</th><th>Teacher Name</th><th>IP-Address</th><th>Timestamp</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        <?php } ?>
      </main>
    </div>
  </div>
  <?php include('scripts.php')?>
  <!-- Graphs -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
  <script type="text/javascript" src="chart_.js"></script>
  <?php if($isAdmin){ ?>
    <script>
      $(document).ready(()=>{
        function getData() {
          $.get('http://localhost:90/qec/api_.php?request=siginlog')
          .then((data)=> {
            data = JSON.parse(data);
            if(data.status == 200){
              var content = '';
              data.data.map((value, key)=>{
                content += '<tr>';
                content += '<td>' + (key + 1) +'</td>';
                content += '<td>' + value.teacherName + '</td>';
                content += '<td>' + value.ip_address + '</td>';
                content += '<td>' + value.timestamp + '</td>';
                content += '</tr>';
              });
              $('#log-table tbody').html(content);
            }
          });
        }
        getData();
        setInterval(() => {
          getData();
        }, 5000);
      })
    </script>
  <?php } ?>
</body>
</html>
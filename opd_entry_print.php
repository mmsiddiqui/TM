<?php include "logic.php" ?>
<?php
$entryID = null;
$edit_title = null;
if(empty($_GET['entry_id'])) _die("No entry found, go back");

$entryID    = $_GET['entry_id'];
$edit_title = "Print OPD Entry";

$entry = mysqli_query($conn, "SELECT o.*, t.typeName, ot.`titleName`  from opd_entries o INNER JOIN `opd_types` t ON o.`opdType` = t.`typeID` INNER JOIN `opd_patient_titles` ot ON o.`patientNameTitle` = ot.`titleID` WHERE o.entryID = '{$entryID}'");
$entry = mysqli_fetch_array($entry);
if(empty($entry)) _die("No entry found with this id, go back");

?>
<?php $title = 'OPD ENTRY'; include('head.php')?>
<body>
  <?php include('navbar.php')?>
  <div class="container-fluid extra-padding-top">
    <div class="row">
      <?php include('sidebar.php')?>
      <div class="col-md-3">
      </div>
      <div class="col-md-6">
        <br><br>
        <div id="doc">
          <div class="row">
            <div class="col-md-10">
              <table class="table table-bordered">                  
                <tr><td>Serial#</td><td><strong><?php echo $entry['entryID'] ?></strong></td></tr>
                <tr><td>Name</td><td><strong><?php echo $entry['titleName'] . ' '. $entry['patientName'] ?></strong></td></tr>
                <tr><td>Age</td><td><strong><?php echo $entry['patientAge'] ?></strong></td></tr>
                <tr><td>Type</td><td><strong><?php echo $entry['typeName'] ?></strong></td></tr>
                <tr><td>Description</td><td><strong><?php echo $entry['opdDescription'] ?></strong></td></tr>
                <tr><td>Date</td><td><strong><?php echo $entry['opdDate'] ?></strong></td></tr>
                <tr><td>Total Charges</td><td><strong>Rs. <?php echo $entry['opdAmountTotal'] ?>/-</strong></td></tr>
                <tr><td colspan="2 text-center"><button id="printBtn" class="btn btn-primary">Print</button></td></tr>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php include('scripts.php')?>
  <script type="text/javascript">
    $html = '<style>body {table {font-size: 10px;font-family:Calibri;}</style><table style="width:100%"><tr><td align ="left">SALE ORDER NO</td><td align ="right">S01</td></tr><tr><td align ="left">SALE ORDER D/TIME</td><td align ="right">2009/01/01</td></tr><tr><td align ="left">CUSTOMER</td><td align ="right">JOHN DOE</td></tr></table>';
    $('#printBtn').click(function() {
      $('#printBtn').hide();
      Popup($('#doc').html());
      $('#printBtn').show();
    })
    function Popup(data) 
    {
      var myWindow = window.open('', 'OPD Receipt', 'height=200,width=600');
      myWindow.document.write('<html><head><title>OPD Receipt</title>');
    /*optional stylesheet*/ //myWindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
    myWindow.document.write('<style type="text/css"> *, html {margin:0;padding:0;} </style>');
    myWindow.document.write('</head><body>');
    myWindow.document.write('<center><h4>Al-Khair General Hospital</h4></center>');
    myWindow.document.write('<center><small>Plot# A/25, 1st Floor, Sector 13/A, Scheme-33, Ali Town, Super Highway, Karachi</small></center>');
    myWindow.document.write('<br><br>');
    myWindow.document.write(data);
    myWindow.document.write('<br><br><br>');
    myWindow.document.write('Signature _______________');
    myWindow.document.write('<br><br><br>');
    myWindow.document.write('<center>Powered by Taiba.Tech</center>');
    myWindow.document.write('<center>contact@taiba.tech</center>');
    myWindow.document.write('</body></html>');
    myWindow.document.close(); // necessary for IE >= 10

    myWindow.onload=function(){ // necessary if the div contain images

        myWindow.focus(); // necessary for IE >= 10
        myWindow.print();
        // myWindow.close(); 
      };
    }
  </script>
</body>
</html>
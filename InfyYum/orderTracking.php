
<html>
<!-- Latest compiled and minified CSS -->
<head>


    <link rel="stylesheet" href="css/vendor.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <!-- Font Awesome -->
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
 <!-- Bootstrap core CSS -->
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <!-- Material Design Bootstrap -->
 <link href="css/mdb.min.css" rel="stylesheet">
 <!-- Your custom styles (optional) -->
 <link href="css/style.css" rel="stylesheet">

</head>


<?php
error_reporting(E_ALL & ~E_NOTICE);

$name=$_GET["uname"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cube2table";
$dbstatus='';
$ready=$_POST["ready"];
$complete=$_POST["complete"];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
$li='';
$li1='';
$li2='';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST['ready'])) {
  if($_POST['ready']!='') {
    $sql = "UPDATE ordering SET ordstatus='READY' where ordid='".$ready."' and lockorder=0";

    if ($conn->query($sql) === TRUE) {
        if($conn->affected_rows > 0){
            $dbstatus =  "Ready State has been updated - ".$ready;
        }
        else{
            $dbstatus =  "Invalid Order Details ".$ready;
        }
    } else {
        $dbstatus = "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
if(isset($_POST['complete'])) {
  if($_POST['complete']!='') {
    $sql = "UPDATE ordering SET ordstatus='COMPLETE', lockorder=1 where ordid='".$complete."'";

    if ($conn->query($sql) === TRUE) {
      if($conn->affected_rows > 0){
          $dbstatus =  "Ready State has been updated - ".$ready;
      }
      else{
          $dbstatus =  "Invalid Order Details ".$ready;
      }
    } else {
        $dbstatus = "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}


$sql1 = "SELECT  v.prodid,o.ordid,v.menu FROM ordering  o, vendor v where v.prodid=o.prodid and v.vendor=o.vendor and o.ordstatus='PENDING' and v.vendor='".$name."' ORDER BY o.ordid ASC";
  foreach ($conn->query($sql1) as $row) {
      $li  .= '<div class=" row" data-type="local"><div class="menu p-4 col-4">' .$row['ordid'].'</div><div class="qty p-4 col-4">'.$row['prodid'].'</div><div class="price p-4 col-4">'.$row['menu'].'</div></div>';
  }

  $sql1 = "SELECT  v.prodid,o.ordid,v.menu FROM ordering  o, vendor v where v.prodid=o.prodid and v.vendor=o.vendor and o.ordstatus='READY' and v.vendor='".$name."' ORDER BY o.ordid ASC";
    foreach ($conn->query($sql1) as $row) {
        $li1  .= '<div class=" row" data-type="local"><div class="menu p-4 col-4">' .$row['ordid'].'</div><div class="qty p-4 col-4">'.$row['prodid'].'</div><div class="price p-4 col-4">'.$row['menu'].'</div></div>';
    }

    $sql1 = "SELECT  v.prodid,o.ordid,v.menu FROM ordering  o, vendor v where v.prodid=o.prodid and v.vendor=o.vendor and o.ordstatus='COMPLETE' and v.vendor='".$name."' ORDER BY o.ordid ASC";
      foreach ($conn->query($sql1) as $row) {
          $li2  .= '<div class=" row" data-type="local"><div class="menu p-4 col-4">' .$row['ordid'].'</div><div class="qty p-4 col-4">'.$row['prodid'].'</div><div class="price p-4 col-4">'.$row['menu'].'</div></div>';
      }


$conn->close();
 ?>
<body>
  <div class="customHeader">Hello &nbsp<span class="customHeaderName text-uppercase"><?=$name ?></span></div>
<div class="container">
    <form class="form-horizontal" action="" method="POST">
    <div class="form-group">
      <label class="control-label col-sm-8" for="email">Ready State Update</label>
      <div class="col-sm-10">
        <input type="text"name="ready" class="form-control" id="ready" placeholder="Enter orderId">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-8" for="pwd">Completion State Update</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="complete" id="complete" placeholder="Enter orderId">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
    </form>
    <div class="col-12 text-center dbStatus">
      <?=$dbstatus?>
    </div>
</div>
<div class="container">
    PENDING ORDERS
    <?=$li  ?>
</div>
<div class="container">
    READY ORDERS
    <?=$li1 ?>
</div>
<div class="container">
    COMPLETE ORDERS
    <?=$li2 ?>
</div>
</body>
</hmtl>

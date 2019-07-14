
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
$name=$_GET["uname"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cube2table";
$dbstatus='';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
$li='';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

global $value2;
$value='';
  $query1 = "SELECT prodid from vendor order by prodid desc LIMIT 1";
  $stmt = $conn->query($query1);

  if ($stmt->num_rows > 0) {
      $row = $stmt->fetch_assoc();
      $value2 = $row['prodid'];
      $value2 = substr($value2, 4, 5);
      $value2 = (int) $value2 + 1;
      $value2 = "PROD" . sprintf('%04s', $value2);
      $value = $value2;
  } else {
      $value2 = "PROD0001";
      $value = $value2;
  }






if(isset($_POST['menu'])) {
  if($_POST['menu']!='') {
    $sql = "INSERT INTO vendor VALUES ('".$_POST['menu']."','".$_POST['qty']."','".$_POST['price']."','".$_GET["uname"]."','".$value."')";

    if ($conn->query($sql) === TRUE) {
        $dbstatus =  "Menu has been added - ".$value;
    } else {
        $dbstatus = "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}
$sql1 = "SELECT * FROM vendor where vendor='".$name."'";
  foreach ($conn->query($sql1) as $row) {
      $li  .= '<div class=" row" data-type="local"><div class="menu p-4 col-4">' .$row['menu'].'</div><div class="qty p-4 col-4">'.$row['qty'].'</div><div class="price p-4 col-4">'.$row['price'].'</div></div>';
  }


$conn->close();
 ?>
<body>
  <div class="customHeader">Hello &nbsp<span class="customHeaderName text-uppercase"><?=$name ?></span></div>
<div class="container">
    <form class="form-horizontal" action="" method="POST">
    <div class="form-group">
      <label class="control-label col-sm-2" for="email">Email:</label>
      <div class="col-sm-10">
        <input type="text"name="menu" class="form-control" id="menu" placeholder="Enter menu">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Quantity:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="qty" id="qty" placeholder="Enter qty">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd">Price:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" name="price" id="price" placeholder="Enter price">
      </div>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
        <button type="button" onclick='window.location.href="orderTracking.php?uname=<?=$name?>"' class="btn btn-danger">Order Tracking</button>
        <button type="button" onclick='window.location.href="feedbackVendor.php?uname=<?=$name?>"' class="btn btn-success">Feedback</button>
      </div>
    </div>
    </form>
    <div class="col-12 text-center dbStatus">
      <?=$dbstatus?>
    </div>
</div>
<div class="container">
  <table data-vertable="ver1">
    <thead>
      <tr class="row100 row head">
        <th class="column100 col-3" data-column="column1">OrderID</th>
        <th class="column100 col-3" data-column="column2">ProductName</th>
        <th class="column100 col-1" data-column="column3">Foodcourt</th>
        <th class="column100 col-2" data-column="column3">Vendor</th>
        <th class="column100 col-2" data-column="column3">Date</th>
        <th class="column100 col-1" data-column="column3">Price</th>

      </tr>
    </thead>

</table>
<?=$li  ?>
</div>
</body>
</hmtl>


<html>
<!-- Latest compiled and minified CSS -->
<head>


    <link rel="stylesheet" href="css/vendor.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script src="js/star.js"></script>

  <!-- Font Awesome -->
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
 <!-- Bootstrap core CSS -->
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <!-- Material Design Bootstrap -->
 <link href="css/mdb.min.css" rel="stylesheet">
 <!-- Your custom styles (optional) -->
 <link href="css/style.css" rel="stylesheet">

 <link href="css/vendor.css" rel="stylesheet">
 <script>
    function redirect(id,name,vendor){
      var url="employeeStatus.php?uname="+name+"&prodid="+id+"&vendor="+vendor;
      window.location = url;
    }
 </script>

</head>


<?php

error_reporting(E_ALL & ~E_NOTICE);

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
$opt='';
$opt1='';
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
$sql1 = "SELECT DISTINCT vendor FROM vendor";
$menuList=$conn->query($sql1);
  if (is_object($menuList)) {
    foreach ($menuList as $row) {
        $opt .= '<option>' .$row['vendor'];
    }
  }
if(isset($_POST['fcOpt'])) {
    if($_POST['fcOpt']!='') {
        $sql1 = "SELECT * FROM vendor where vendor=".$_POST['fcOpt'];
        $menuList=$conn->query($sql1);
            if (is_object($menuList)) {
              foreach ($menuList as $row) {
                  $opt1 .= '<option value='.$row['prodid'].'>' .$row['menu'];
              }
            }
    }
}

if(isset($_POST['rate'])) {
  if($_POST['rate']!='') {
    $sql = "INSERT INTO feedback VALUES ('".$_POST['prodid']."','".$_POST['rate']."','".$_POST['comments']."')";

    if ($conn->query($sql) === TRUE) {
        $dbstatus =  "Feedback has been added ";
    } else {
        $dbstatus = "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}



$conn->close();
 ?>
<body>
  <div class="customHeader">Hello &nbsp<span class="customHeaderName text-uppercase"><?=$name ?></span></div>
<div class="container">
    <form class="form-horizontal" action="" method="POST">
    <div class="form-group">
      <label for="sel1">Select list:</label>
      <select class="form-control" id="sel1" name="fcOpt">
        <?=$opt  ?>
      </select>
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
    <div class="form-group">
      <label for="sel1">Select list:</label>
      <select class="form-control" id="sel1" name="prodid">
        <?=$opt1  ?>
      </select>
      <script type="text/javascript" src="Jquery-simple-rating-system-with-small-stars_files/jquery.js"></script>
              <link
href="Jquery-simple-rating-system-with-small-stars_files/rating_simple.css"
rel="stylesheet" type="text/css">
    <script type="text/javascript" src="Jquery-simple-rating-system-with-small-stars_files/rating_simple.js"></script>
    <div class="form-group p-4">
              Rate:<br><br>
              <input name="rate" value="5"
              id="rating_simple2" type="hidden">

    </div>
    <div class="form-group">
      <label for="comments">Comments:</label>
      <input name="comments" id="comments" class="form-control" type="text">
    </div>
    <div class="form-group">
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  <script language="javascript" type="text/javascript">
          $(function() {
$("#rating_simple2").webwidget_rating_simple({
                  rating_star_length: '5',
                  rating_initial_value: '',
                  rating_function_name: '',//this is function name for click
                  directory: 'Jquery-simple-rating-system-with-small-stars_files/'
              });
          });
      </script>
    </div>
    </form>
    <div class="row">
      <div class="col-12 text-center dbStatus">
        <?=$dbstatus?>
      </div>
    </div>
</div>
<div class="container">
    <?=$li  ?>
</div>
</body>
</hmtl>

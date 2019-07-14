
<html>
<!-- Latest compiled and minified CSS -->
<head>


    <link rel="stylesheet" href="css/vendor.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script src="js/custom.js"></script>

  <!-- Font Awesome -->
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
 <!-- Bootstrap core CSS -->
 <link href="css/bootstrap.min.css" rel="stylesheet">
 <!-- Material Design Bootstrap -->
 <link href="css/mdb.min.css" rel="stylesheet">
 <!-- Your custom styles (optional) -->
 <link href="css/style.css" rel="stylesheet">
 <script>
    function redirect(id,name,vendor){
      var url="employeeStatus.php?uname="+name+"&prodid="+id+"&vendor="+vendor;
      window.location = url;
    }
 </script>

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
$opt='';
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
                  $li  .= '<div class=" row" data-type="local"><div class="menu p-4 col-3">' .$row['menu'].'</div><div class="qty p-4 col-3">'.$row['qty'].'</div><div class="price p-4 col-3">'.$row['price'].'</div>';
                  $li  .= "<div class='menu p-4 col-3'><button type='submit' onclick='redirect("."\"".$row['prodid']."\"".","."\"".$name."\"".","."\"".$row['vendor']."\"".")' class='btn btn-success'>Order</button></div></div>";
              }
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
    </form>
    <div class="col-12 text-center">
      <button type="button" onclick='window.location.href="feedback.php?uname=<?=$name?>"' class="btn btn-danger">Feedback</button>
    </div>
</div>
<div class="container">
    <?=$li  ?>
</div>
</body>
</hmtl>

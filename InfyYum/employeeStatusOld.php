
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
    function redirect(id,name){
      var url="test.php?uname="+name+"&prodid="+id;
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
  $query1 = "SELECT ordid from ordering order by ordid desc LIMIT 1";
  $stmt = $conn->query($query1);

  if ($stmt->num_rows > 0) {
      $row = $stmt->fetch_assoc();
      $value2 = $row['ordid'];
      $value2 = substr($value2, 3, 5);
      $value2 = (int) $value2 + 1;
      $value2 = "ORD" . sprintf('%04s', $value2);
      $value = $value2;
  } else {
      $value2 = "ORD0001";
      $value = $value2;
  }






if(isset($_GET["prodid"])) {
  if($_GET["prodid"]!='') {
    $sql = "INSERT INTO ordering VALUES ('".$_GET["prodid"]."','".$_GET["uname"]."','".$value."','PENDING','".$_GET["vendor"]."')";

    if ($conn->query($sql) === TRUE) {
        $dbstatus =  "ORDER SUCCESSFUL - ".$value;
    } else {
        $dbstatus = "Error: " . $sql . "<br>" . $conn->error;
    }

    $sql = "UPDATE vendor SET qty=qty-1 where prodid='".$_GET["prodid"]."'";

    if ($conn->query($sql) === TRUE) {
        $dbstatus =  "UPDAT SUCCESSFUL - ".$value;
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
        <div class="col-12 text-center dbStatus">
      <?=$dbstatus?>
        <span id="pendingNumbers"></span>
    </div>
</div>
<div class="container">
    <?=$li  ?>
</div>
<script>
$( document ).ready(function() {
    setInterval(function(){   showOrders('<?=$_GET["prodid"]?>','<?=$_GET["uname"]?>','<?=$_GET["vendor"]?>','<?=$value?>');  }, 3000);
});

</script>
</body>
</hmtl>

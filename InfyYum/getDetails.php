<?php
$name=$_GET["uname"];
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cube2table";
$dbstatus='';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$query1 = "SELECT count(ordid) as ordcount from ordering where vendor='".$_GET["vendor"]."' and ordstatus='PENDING' and CAST(SUBSTRING(ordid, 4, 7) AS UNSIGNED) < CAST(SUBSTRING('".$_GET["ordid"]."', 4, 7) AS UNSIGNED)";

$stmt = $conn->query($query1);

if ($stmt->num_rows > 0) {
    $row = $stmt->fetch_assoc();
    echo $_GET["ordid"]."~".$row['ordcount']."~".$row['ordcount']*1.68."~";
}else {
    echo 0;
}

$query1 = "SELECT ordstatus from ordering where ordid='".$_GET["ordid"]."'";
$stmt = $conn->query($query1);

if ($stmt->num_rows > 0) {
    $row = $stmt->fetch_assoc();
    echo $row['ordstatus'];
    $row = $stmt->fetch_assoc();
}else {
    echo 0;
}



 ?>


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




 ?>
<body>
  <div class="customHeader">Hello &nbsp<span class="customHeaderName text-uppercase"><?=$name ?></span></div>
<div class="container">
      <script type="text/javascript" src="Jquery-simple-rating-system-with-small-stars_files/jquery.js"></script>
              <link
href="Jquery-simple-rating-system-with-small-stars_files/rating_simple.css"
rel="stylesheet" type="text/css">
    <script type="text/javascript" src="Jquery-simple-rating-system-with-small-stars_files/rating_simple.js"></script>
<?php

if(isset($_GET['uname'])) {
    if($_GET['uname']!='') {
        $sql1 = "SELECT f.prodid,round(avg(f.rate)) avgrate,v.menu FROM feedback f,vendor v WHERE f.prodid=v.prodid and f.prodid in (SELECT prodid from vendor WHERE vendor='".$_GET['uname']."') group by prodid";
        $menuList=$conn->query($sql1);
            if (is_object($menuList)) {
              foreach ($menuList as $row) {
?>


    <div class="p-4">
              <?=$row["menu"]?><br><br>
              <input name="rate" value="5"
              id="rating_simple<?=$row["prodid"]?>" type="hidden">

    </div>
  <script language="javascript" type="text/javascript">
          $(function() {
$("#rating_simple<?=$row["prodid"]?>").webwidget_rating_simple({
                  rating_star_length: '5',
                  rating_initial_value: '<?=$row["avgrate"]?>',
                  rating_function_name: '',//this is function name for click
                  directory: 'Jquery-simple-rating-system-with-small-stars_files/'
              });
          });
      </script>
  <?php

                    }
                  }
          }
      }

      if(isset($_GET['uname'])) {
          if($_GET['uname']!='') {
              $sql1 = "SELECT comments FROM feedback";
              $menuList=$conn->query($sql1);
                  if (is_object($menuList)) {
                    $li  = '<div class=" row" data-type="local">';
                    foreach ($menuList as $row) {
                        if($row['comments']!=''){
                          $li  .= '<div class="menu p-4 col-12">' .$row['comments'].'</div>';
                        }
                    }
                  }
          }
      }

$conn->close();
       ?>
    <div class="row">
      <div class="col-12 text-center dbStatus">
        <?=$dbstatus?>
      </div>
    </div>
</div>
<div class="container">
    Comments :
    <?=$li  ?>
</div>
</body>
</hmtl>

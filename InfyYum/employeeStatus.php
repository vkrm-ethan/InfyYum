
<html>
<!-- Latest compiled and minified CSS -->
<head>


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>MeetMe - Resume Website Template</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" >
    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/font-awesome.min.css">
    <!-- Icon -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/simple-line-icons.css">
    <!-- Slicknav -->
    <link rel="stylesheet" type="text/css" href="assets/css/slicknav.css">
    <!-- Menu CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/menu_sideslide.css">
    <!-- Slider CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/slide-style.css">
    <!-- Nivo Lightbox -->
    <link rel="stylesheet" type="text/css" href="assets/css/nivo-lightbox.css" >
    <!-- Animate -->
    <link rel="stylesheet" type="text/css" href="assets/css/animate.css">
    <!-- Main Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">


  </head>
  <body>
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
        $sql = "INSERT INTO ordering VALUES ('".$_GET["prodid"]."','".$_GET["uname"]."','".$value."','PENDING','".$_GET["vendor"]."','0')";

        if ($conn->query($sql) === TRUE) {
            $dbstatus1 =  "ORDER SUCCESSFUL - ".$value;
        } else {
            $dbstatus1 = "Error: " . $sql . "<br>" . $conn->error;
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

    <!-- Header Area wrapper Starts -->
    <header id="header-wrap">
      <!-- Navbar Start -->

      <!-- Hero Area Start -->
      <div id="hero-area" class="hero-area-bg">
        <div class="overlay"></div>
        <div class="container">
          <div class="row">
            <div class="col-md-12 col-sm-12 text-center">
              <div class="contents">
                <h5 id="user-msg" class="script-font wow fadeInUp" data-wow-delay="0.2s"></h5>


              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Hero Area End -->

    </header>
    <!-- Header Area wrapper End -->

    <!-- Counter Area Start-->
    <section style="height:300px;" class="counter-section section-padding">
      <div class="container">
        <div id="ready-hide" class="row">
          <!-- Counter Item -->
          <div class="col-md-4 col-sm-6 work-counter-widget text-center">
            <div class="counter wow fadeInDown" data-wow-delay="0.3s">
              <div class="icon"><i class="icon-briefcase"></i></div>
              <div id="ord-id" style="
    color: #fff;
    font-size: 42px;
    margin-top: 15px;
    font-weight: 700;
"></div>
              <p>Order Id</p>
            </div>
          </div>
          <!-- Counter Item -->
          <div class="col-md-4 col-sm-6 work-counter-widget text-center">
            <div class="counter wow fadeInDown" data-wow-delay="0.6s">
              <div class="icon"><i class="icon-user"></i></div>
              <div id="ord-count" class="counterUp"></div>
              <p>Previous Orders</p>
            </div>
          </div>
          <!-- Counter Item -->
          <div class="col-md-4 col-sm-6 work-counter-widget text-center">
            <div class="counter wow fadeInDown" data-wow-delay="0.9s">
              <div class="icon"><i class="icon-clock"></i></div>
              <div id="time-left" class="counterUp"></div>
              <p>Approx. Time left</p>
            </div>
          </div>
          <!-- Counter Item -->

          </div>
        </div>
      </div>
    </section>
    <!-- Counter Area End-->


    <!-- Go to Top Link -->
    <a href="#" class="back-to-top">
      <i class="icon-arrow-up"></i>
    </a>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="assets/js/jquery-min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.mixitup.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/wow.js"></script>
    <script src="assets/js/jquery.nav.js"></script>
    <script src="assets/js/jquery.easing.min.js"></script>
    <script src="assets/js/nivo-lightbox.js"></script>
    <script src="assets/js/jquery.slicknav.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="js/custom.js"></script>

<script>
$( document ).ready(function() {
    showOrders('<?=$_GET["prodid"]?>','<?=$_GET["uname"]?>','<?=$_GET["vendor"]?>','<?=$value?>'); 
    setInterval(function(){   showOrders('<?=$_GET["prodid"]?>','<?=$_GET["uname"]?>','<?=$_GET["vendor"]?>','<?=$value?>');  }, 3000);
});

</script>
</body>
</hmtl>

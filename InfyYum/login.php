
<?php
$username='';
$password='';
$error='';
if(isset($_POST['username'])) {
  $username=$_POST['username'];
}
if(isset($_POST['password'])) {
  $password=$_POST['password'];
}
if($username == 'vendor' && $password =='vendor'){
  header('Location: vendor.php?uname='.$username);
  exit();
}else if($username == 'infy' && $password =='infy'){
  header('Location: employee.php?uname='.$username);
  exit();
}else if($username =='' && $password ==''){
  $error='';
}else{
  $error='Invalid UserName/Password';
}

 ?>

<html>
<div><?=$error?></div>
<form name="login" action="" method="POST">
    <input type="text" name="username" value="<?=$username?>" />
    <input type="password" name="password" />
    <input type="Submit" value="Login">
</form>
</html>

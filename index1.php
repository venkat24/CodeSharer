<html>
  Hi
</html>
<?php
$email="";
$password="";
if($_SERVER["REQUEST_METHOD"]=="POST"){
if(isset($_POST["name"])){
$email=test_input($_POST['email']);
$password=test_input($_POST['password']);
session_start();
if($email!=""&&$password!=""){
$_SESSION["email"]=$email;
$_SESSION["password"]=password_hash($password,PASSWORD_DEFAULT);
header('Location: loggedin.php');
exit();
}
}
else {
header('Location: index.html');
exit();
}
}
function test_input($data){
  if($data==null)
  return $data;
  $data=trim($data);
  $data=stripslashes($data);
  $data=htmlspecialchars($data);
  return $data;
}
?>

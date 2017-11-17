<?php
session_start();
$error="";
$username="";
$password="";
$name="";
if($_SERVER['REQUEST_METHOD']==="POST"){
    $_SESSION['error']="";
    $name=$_POST['username'];
    $password=htmlspecialchars($_POST['password']);
    $username=$_POST['username'];
    if(test_name($name)!=0)
    {
        $_SESSION['errors']=1;
        if(test_name($name)==2)
            $_SESSION['error']="Name Field is Blank  <br /> ";
        if(test_name($name)==1)
            $_SESSION['error']="Illegal Name Field <br />  ";
    }
    if(test_name($_POST['username'])!=0)
    {
        $_SESSION['errors']=1;
        if(test_name($_POST['username'])==2)
            $_SESSION['error'] .= "Username Field is Blank <br />  ";
        if(test_name($_POST['username'])==1)
            $_SESSION['error'] .="Illegal Username Field <br />";
    }

    if($_SESSION['errors']!=1){
        require('config.php');
        $password=password_hash($password, PASSWORD_BCRYPT);
        $sql="SELECT * FROM users WHERE username = "."'". $username ."'";
        $result=$conn->query($sql);
        if($result->num_rows>0){
            $_SESSION['errors']=1;
            $thisthing=$result->fetch_assoc();
            $_SESSION['error'].="Username taken ".$thisthing['username'];
        } else {
            $insert=$conn->prepare("INSERT INTO users (username,password,balance,isAdmin) VALUES(?,?,10000,0)");
            $insert->bind_param("ss", $username, $password);
            $insert->execute();
            $insert->close();
            $conn->close();
            echo "Registration Successful! Please Login.";
        }
    }
    if($_SESSION['errors']==1){
        header("Location: index.php");
        exit();
    }
}
if(isset($_SESSION['errors']))
    if($_SESSION['errors']==1&&isset($_SESSION['error']))
        $error=$_SESSION['error'];
echo $error;
$_SESSION['errors']=0;
function test_name($var){
    if($var==="")
        return 2;
    else
        if(!preg_match("/^[a-zA-Z ]*$/",$var))
            return 1;
        else
            return 0;
}
function test_password($pass)
{
    if(strlen($pass)<8)
        return 1;
    return 0;
}
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <meta charset="utf-8">
    <title>Login</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>
    <div class="container">
    <h1>Stocks Portal</h1>
    <div class="form-container">
      <h2>Register</h2>
      <form action="" method="post">
        Username <br />
        <input type="text" name="username" value="" onkeyup="showResult(this.value)" required>
        <a id="livesearch">
        </a>
        <br />
        Password <br>
        <input type="password" name="password" value="" required><br>
        <input type="submit" value="Register"/>
      </form>
    </div>
    <div class="form-container">
      <h2>Login</h2>
      <form action="login.php" method="post">
        Username<br />
        <input type="text" name="username" value=""><br>
        Password <br>
        <input type="password" name="password" value=""><br>
        <input type="submit" value="Login"/>
      </form>
    </div>
    <div>
  </body>
<script type="text/javascript">
function showResult(str) {
    if(str.length==0){
        document.getElementById('livesearch').innerHTML="";
        return;
        }
        else{
            http=new XMLHttpRequest();
        }
        http.onreadystatechange=function(){
            document.getElementById('livesearch').innerHTML=http.responseText;
        }
        http.open("GET","livesearch.php?q="+str,true);
        http.send();
      }
    </script>
</html>

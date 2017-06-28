<?php
  session_start();
  $error="";
  $username="";
  $password="";
  $name="";
  if($_SERVER['REQUEST_METHOD']==="POST"){
    $_SESSION['error']="";
    $name=$_POST['name'];
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
    if(!isset($_POST['g-recaptcha-response'])){
      $_SESSION['errors']=1;
      $_SESSION['error'].="CAPTCHA NOT ENTERED";
    }
    else{
        $captcha=$_POST['g-recaptcha-response'];
        $response=json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lfm8yYUAAAAAMU-ZVVJLboGdrZ7AHsH8hNgCmmS&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        if($response['success'] == false)
        {
          $_SESSION['errors']=1;
          $_SESSION['error'].="CAPTCHA INCORRECT";
        }
        else
        {
        }
    }
    if(test_password($password)!=0){
      $_SESSION['errors']=1;
      if(test_password($password)==1)
        $_SESSION['error'] .= "Password is too weak <br />  ";
    }

    if($_SESSION['errors']!=1){
      $username_server="root";
      $database="task1DB";
      $password_server="";
      $server="localhost";
      $password=password_hash($password,PASSWORD_BCRYPT);
      $conn=new mysqli($server, $username_server, $password_server, $database);
      $sql="SELECT * FROM Users WHERE username = "."'". $username ."'";
      $result=$conn->query($sql);
      if($result->num_rows>0){
          $_SESSION['errors']=1;
          $thisthing=$result->fetch_assoc();
          $_SESSION['error'].="Username taken ".$thisthing['username'];
      }
      else{
        $connect=new mysqli($server, $username_server, $password_server, $database);
        $insert=$connect->prepare("INSERT INTO Users (username,name,password) VALUES(?,?,?)");
        $insert->bind_param("sss",$username,$name,$password);
        $insert->execute();
        $insert->close();
        $conn->close();
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
    <style>
      .forms{
        margin-left: 30%;
        margin-top: 10%;
      }
      .formss{
        margin-left: 30%;
        margin-top: 10%;
      }
    </style>
    <meta charset="utf-8">
    <title>Login</title>
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>
  <body>
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
    <div class="forms">
      <form action="login.php" method="post">
        Email id <br />
        <input type="text" name="username" value=""><br>
        Password <br>
        <input type="password" name="password" value=""><br>
        <input type="submit" />
      </form>
    </div>
    <div class="formss">
      <form action="" method="post">
        Username <br />
        <input type="text" name="username" value="" onkeyup="showResult(this.value)">
        <a id="livesearch">
        </a><br>
        Name <br />
        <input type="text" name="name" value=""><br>
        Password <br>
        <input type="password" name="password" value=""><br>
        <div class="g-recaptcha" data-sitekey="6Lfm8yYUAAAAABbqfjRoU1lEUZhN6rmNmnA3lCmQ"></div>
        <input type="submit" />
      </form>
    </div>
  </body>
</html>

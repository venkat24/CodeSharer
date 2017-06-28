<?php
  session_start();
  $error="";
  $username="";
  $password="";
  $name="";
  if($_SERVER['REQUEST_METHOD']==="POST"){
    $_SESSION['error']="";
    $username=$_POST['username'];
    $password=htmlspecialchars($_POST['password']);
    if(test_name($_POST['username'])!=0)
    {
      $_SESSION['errors']=1;
      if(test_name($_POST['username'])==2)
      $_SESSION['error'] .= "Username Field is Blank <br />  ";
      if(test_name($_POST['username'])==1)
      $_SESSION['error'] .="Illegal Username Field <br />";
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
      $conn=new mysqli($server, $username_server, $password_server, $database);
      $sql="SELECT * FROM Users WHERE username = '" . $username ."'";
      $result=$conn->query($sql);
      if($result->num_rows==0){
          $_SESSION['errors']=1;
          $_SESSION['error'].="Username does not exist";
      }
      else{
          $row=$result->fetch_assoc();
          if(password_verify($password,$row['password'])){
              $_SESSION['name']=$row['name'];
              $_SESSION['username']=$username;
              $conn->close();
              header('Location: loggedin.php');
              exit();
            }
          else{
            $conn->close();
            $_SESSION['errors']=1;
            $cutpassword=$row['password'];
            $_SESSION['error'].="Wrong Password ";
          }
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

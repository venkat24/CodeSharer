<?php
session_start();
illegal_login_attempt();
logout_from_page();
function illegal_login_attempt(){
    if(!isset($_SESSION['username'])){
        header('Location: index.php ');
        exit();
    }
}
function logout_from_page(){
    if(isset($_GET["logout"])){
        session_destroy();
        header('Location: index.php');
        exit();
    }
}
?>
<html>
  <head>
    <title>Welcome to Stocks Management System</title>
  </head>
  <body>
    <form class="" action="" method="GET">
      <input type="submit" name="logout" value="logout">
    </form>
  </body>
</html>

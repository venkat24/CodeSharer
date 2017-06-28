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
  function get_code(){
    if($_SERVER['REQUEST_METHOD']=="POST"){
      if($_FILES['file']['size']<40000){
        $file=file_get_contents($_FILES["file"]["tmp_name"]);
        return $file;
      }
    }
  }
?>
<html>
  <head>
    <style media="screen">
      button{
        margin-left: 50% ;
      }
    </style>
    <meta charset="utf-8">
    <title>Hello</title>
  </head>
  <body>
    <form class="" action="" method="GET">
      <input type="submit" name="logout" value="logout">
    </form>
    <textarea name="name" rows="1" cols="40"><?php
      if(isset($_SESSION['codeid']))
        echo $_SESSION['codeid'];
      unset($_SESSION['codeid']);
      ?></textarea>
    <form class="" action="codes.php" method="POST" enctype="multipart/form-data">
      <textarea name="code" rows="8" cols="80" holder=""><?php echo get_code();?></textarea><br />
      <input type="datetime-local" name="datetime" value=""><br>
      <input type="submit" name="create" value="add snippet">
    </form>
    <form class="" action="" method="post" enctype="multipart/form-data">
      <input type="file" accept=".txt,.java,.js,.php,.html,.sh,.c,.cpp" name="file" value="" ><br />
      <input type="submit" name="create" value="get Code">
    </form>
  </body>
</html>

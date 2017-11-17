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
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="stylesheet" type="text/css" href="admin.css">
    <meta charset="utf-8">
    <title>Welcome to Stocks Management System</title>
  </head>
  <body>
    <div class="form-container">
      <h2>Add Company</h2>
      <form action="addcompany.php" method="post">
        <!-- Need to check to make sure company doesn't already exist !-->
        Company Name : 
        <input type="text" name="company" style="margin: 5px;">
        <br>
        Set Price : 
        <input type="number" step="0.01" width="20px;" name="price" min="1">
        <br>
        <input type="submit" value="Create IPO">
      </form>
    </div>

    <div class="form-container">
      <h2>Change Price</h2>
      <form action="changeprice.php" method="post">
        Company : 
        <select name="company">
<?php
      require_once('config.php');
      $company="SELECT name from companies";
      $result=$conn->query($company);
      while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row["name"].'">'.$row["name"].'</option>';
      }
          ?>
        </select>
        <br>
        <!-- Check to make sure the user has enough quantity!-->
        New Price : 
        <input type="number" step="0.01" width="20px;" name="newprice" min="1">
        <br>
        <input type="submit" value="Change">
      </form>
    </div>
    <br>

    <form class="" action="" method="GET">
      <input type="submit" name="logout" value="logout">
    </form>
  </body>
</html>

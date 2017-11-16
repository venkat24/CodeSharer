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
    <link rel="stylesheet" type="text/css" href="welcome.css">
    <meta charset="utf-8">
    <title>Welcome to Stocks Management System</title>
  </head>
  <body>
    <div>
      <h2>Portfolio</h2>
      <table>
        <tr>
          <th width="150px">Company</th>
          <th width="150px">Current Price</th>
          <th width="100px">Quantity</th>
          <th width="200px">Total Value</th>
        </tr>

        <tr>
          <td>Apple</td>
          <td>$673.45</td>
          <td>21</td>
          <td>$12,341.32</td>
        </tr>

        <tr>
          <td>Google</td>
          <td>$713.12</td>
          <td>10</td>
          <td>$7131.20</td>
        </tr>

        <tr>
          <td>Facebook</td>
          <td>$29.14</td>
          <td>14</td>
          <td>$346.18</td>
        </tr>

        <tr>
          <td class="silentTD"></td>
          <td class="silentTD"></td>
          <th>Total</th>
          <th>$22,345.12</th>
        </tr>

      </table>
    </div>

    <br>
    <div>
      <h2>Buy Stock</h2>
      <form action="" method="post">
        Stock : 
        <!-- Add CSS to make the select and input fields look better !-->
        <!-- Also add CSS to make Buy, Sell and Logout button look better !-->
        <select name="company">
        <!-- This data needs to be populated from companies table !-->
          <option value="apple">Apple</option>
          <option value="google">Google</option>
          <option value="facebook">Facebook</option>
        </select>
        <br>
        <!-- Check to make sure the user has enough money!-->
        Quantity : 
        <input type="number" width="20px;" name="quantity">
        <br>
        <input type="submit" value="Buy">
      </form>
    </div>

    <br>
    <div>
      <h2>Sell Stock</h2>
      <form action="" method="post">
        Stock : 
        <!-- Add CSS to make the select and input fields look better !-->
        <select name="company">
        <!-- This data needs to be populated from users table to only show companies that the user has!-->
          <option value="apple">Apple</option>
          <option value="google">Google</option>
          <option value="facebook">Facebook</option>
        </select>
        <br>
        <!-- Check to make sure the user has enough quantity!-->
        Quantity : 
        <input type="number" width="20px;" name="quantity">
        <br>
        <input type="submit" value="Sell">
      </form>
    </div>
    <br>

    <form class="" action="" method="GET">
      <input type="submit" name="logout" value="logout">
    </form>
  </body>
</html>
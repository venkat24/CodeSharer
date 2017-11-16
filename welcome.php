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
    <link rel="stylesheet" type="text/css" href="welcome.css">
    <meta charset="utf-8">
    <title>Welcome to Stocks Management System</title>
  </head>
  <body>
    <div>
      <h2>Charts</h2>
      <table>
        <tr>
          <th width="150px">Company</th>
          <th width="150px">Current Price</th>
        </tr>

<?php
      require_once('config.php');
      $company="SELECT name, stock_price FROM companies;";
      $result=$conn->query($company);
      while ($row = $result->fetch_assoc()) {
        echo '
        <tr>
          <td>' .$row["name"].'</td>
          <td>$'.$row["stock_price"].'</td>
        </tr>';
      }
        ?>

      </table>
    </div>
    <div>
      <h2>Portfolio</h2>
      <h3>Current Balance : 
<?php
require_once('config.php');
    $username=$_SESSION['username'];
    $useridsql="SELECT id FROM users WHERE username = "."'".$username."'";
    $idresult=$conn->query($useridsql);
    $row=$idresult->fetch_assoc();
    $userid=$row['id'];

    $balanceidsql="SELECT (users.balance + sum(transactions.total_amount)) as bal FROM users, transactions where users.id = transactions.user_id AND users.id = ".$userid.";";
    $result=$conn->query($balanceidsql);
    $row=$result->fetch_assoc() or error_log($conn->error);
    $balance=$row['bal'];
    if(!$balance) {
      $balanceidsql="SELECT balance from users where id = ".$userid.";";
      $result=$conn->query($balanceidsql);
      $row=$result->fetch_assoc() or error_log($conn->error);
      $balance=$row['balance'];
    }
    echo "$".$balance;
?>
      </h3>
      <table>
        <tr>
          <th width="150px">Company</th>
          <th width="150px">Current Price</th>
          <th width="100px">Quantity</th>
          <th width="200px">Total Value</th>
        </tr>

<?php
      require_once('config.php');
      $username=$_SESSION['username'];
      $useridsql="SELECT id FROM users WHERE username = "."'".$username."'";
      $idresult=$conn->query($useridsql);
      $row=$idresult->fetch_assoc();
      $userid=$row['id'];
      $company="SELECT companies.name as company_name, companies.stock_price as stock_price, (-1)*SUM(qty) as tot_qty, (-1)*SUM(total_amount) as tot_amount FROM transactions, companies WHERE transactions.company_id = companies.id AND user_id = ".$userid." GROUP BY company_id having sum(qty) != 0;";
      $result=$conn->query($company);
      $qtytot=0;
      $pricetot=0;
      while ($row = $result->fetch_assoc()) {
        echo '
        <tr>
          <td>' .$row["company_name"].'</td>
          <td>$'.$row["stock_price"].'</td>
          <td>' .$row["tot_qty"].'</td>
          <td>$'.$row["tot_amount"].'</td>
        </tr>';
        $qtytot+=$row["tot_qty"];
        $pricetot+=$row["tot_amount"];
      }
      echo '
        <tr>
          <td class="silentTD"></td>
          <td class="silentTD"></td>
          <th>' .$qtytot.'</th>
          <th>$'.$pricetot.'</th>
        </tr>'
        ?>

      </table>
    </div>

    <br>
    <div class="form-container">
      <h2>Buy Stock</h2>
      <form action="buystock.php" method="post">
        Stock : 
        <select name="company">
          <?php
      require_once('config.php');
      $company="SELECT name FROM companies;";
      $result=$conn->query($company);
      while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row["name"].'">'.$row["name"].'</option>';
      }
          ?>
        <!-- This data needs to be populated from companies table !-->
        </select>
        <br>
        Quantity : 
        <input type="number" step="0.01" width="20px;" name="qty">
        <br>
        <input type="submit" value="Buy">
      </form>
    </div>

    <div class="form-container">
      <h2>Sell Stock</h2>
      <form action="sellstock.php" method="post">
        Stock :
        <!-- Add CSS to make the select and input fields look better !-->
        <select name="company" id="sellcompany" onchange="updatemax();">
<?php
      $username=$_SESSION['username'];
      $useridsql="SELECT id FROM users WHERE username = "."'".$username."'";
      $idresult=$conn->query($useridsql);
      $row=$idresult->fetch_assoc();
      $userid=$row['id'];
      $company="SELECT DISTINCT companies.name AS name FROM transactions, companies WHERE transactions.company_id = companies.id AND transactions.user_id = ".$userid." GROUP by companies.name HAVING SUM(qty) !=0;";
      $result=$conn->query($company);
      while ($row = $result->fetch_assoc()) {
        echo '<option value="'.$row["name"].'">'.$row["name"].'</option>';
      }
          ?>
        </select>
        <br>
<?php
      require_once('config.php');
      $username=$_SESSION['username'];
      $useridsql="SELECT id FROM users WHERE username = "."'".$username."'";
      $idresult=$conn->query($useridsql);
      $row=$idresult->fetch_assoc();
      $userid=$row['id'];
      $company="SELECT (-1)*SUM(transactions.qty) as eachqty, companies.name as name from transactions, companies WHERE transactions.company_id = companies.id and transactions.user_id = ".$userid." GROUP by companies.name;";
      $result=$conn->query($company);
      echo '<script>';
      echo 'var qtys = {';
      $innerjs="";
      while ($row = $result->fetch_assoc()) {
            $innerjs.=$row["name"].':'.$row["eachqty"].',';
      }
      rtrim($innerjs,',');
      echo $innerjs;
      echo '};';
      echo '</script>';
        ?>
        Quantity : 
        <input type="number" step="0.01" width="20px;" name="qty" id="sellstock" onchange="updatemax();">
        <br>
        <input type="submit" value="Sell">
      </form>
    </div>
    <br>

      <input type="submit" name="logout" value="Logout">
    <form class="" action="" method="GET">
    </form>
      <script>
        function updatemax() {
        document.getElementById('sellstock').max = qtys[document.getElementById('sellcompany').value];
        if (document.getElementById("sellstock").value > qtys[document.getElementById('sellcompany').value]) {
          document.getElementById('sellstock').value = qtys[document.getElementById('sellcompany').value];
        }
      }
      </script>
  </body>
</html>


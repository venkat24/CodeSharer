<?php
session_start();
require('config.php');
if($_SERVER['REQUEST_METHOD']==="POST"){
    $username=$_SESSION['username'];
    $useridsql="SELECT id FROM users WHERE username = "."'".$username."'";
    $idresult=$conn->query($useridsql);
    $row=$idresult->fetch_assoc();
    $userid=$row['id'];

    $company=$_POST['company'];
    $companyidsql="SELECT * FROM companies WHERE name='$company';";
    $idresult=$conn->query($companyidsql);
    $row=$idresult->fetch_assoc() or error_log($conn->error);
    $companyid=$row['id'];
    $stockprice=$row['stock_price'];
    $moneyneeded=$stockprice*$_POST['qty'];

    $balanceidsql="SELECT (users.balance + sum(transactions.total_amount)) as bal FROM users, transactions where users.id = transactions.user_id AND users.id = ".$userid.";";
    $result=$conn->query($balanceidsql);
    $row=$result->fetch_assoc() or error_log($conn->error);
    $balance=$row['bal'];
    if($balance==null) {
      $balanceidsql="SELECT balance from users where id = ".$userid.";";
      $result=$conn->query($balanceidsql);
      $row=$result->fetch_assoc() or error_log($conn->error);
      $balance=$row['balance'];
    }

    $qty=(-1)*$_POST['qty'];
    if($qty<=0 && $balance>=$moneyneeded) {
        $sql="INSERT INTO transactions(user_id, company_id, qty, total_amount) values ($userid, $companyid, $qty, $qty*$stockprice);";
        error_log($sql);
        $result=$conn->query($sql);
    }

    header("Location: welcome.php");
}
?>

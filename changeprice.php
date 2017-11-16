<?php
session_start();
require('config.php');
if($_SERVER['REQUEST_METHOD']==="POST"){
    $company=$_POST['company'];
    $companyidsql="SELECT * FROM companies WHERE name='$company';";
    $idresult=$conn->query($companyidsql);
    $row=$idresult->fetch_assoc() or error_log($conn->error);
    $companyid=$row['id'];

    $sql="UPDATE companies SET stock_price = ".$_POST["newprice"]." WHERE name = '".$_POST["company"]."'";
    $result=$conn->query($sql);
    header("Location: admin.php");
}
?>


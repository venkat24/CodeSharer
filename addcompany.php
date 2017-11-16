<?php
session_start();
require('config.php');
if($_SERVER['REQUEST_METHOD']==="POST"){
    $company=$_POST['company'];
    $companyidsql="SELECT * FROM companies WHERE name='$company';";
    $idresult=$conn->query($companyidsql);
    if($idresult->num_rows > 0) {
      die("Company exists");
    }

    $sql="INSERT INTO companies(name, stock_price) VALUES('".$_POST["company"]."',".$_POST["price"].");";
    error_log($sql);
    $result=$conn->query($sql);
    header("Location: admin.php");
}
?>


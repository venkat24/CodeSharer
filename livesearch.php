<?php
$username=$_GET['q'];
$username_server="root";
$database="task1DB";
$password_server="";
$server="localhost";
$conn=new mysqli($server, $username_server, $password_server, $database);
$sql=" SELECT * FROM Users WHERE username = "."'".$username."'";
$result=$conn->query($sql);
if($result->num_rows==0)
  echo "Available";
else
  echo "Taken";
?>

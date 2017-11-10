<?php
$username=$_GET['q'];
require("config.php");
$sql=" SELECT * FROM Users WHERE username = "."'".$username."'";
$result=$conn->query($sql);
if($result->num_rows==0)
  echo "✓";
else
  echo "✘";
?>

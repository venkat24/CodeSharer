<html>
<link rel="stylesheet" href="/styles/default.css">
<script src="/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>
<code><pre>
<?php
  session_start();
  if(isset($_GET['id'])){
  $uniqid=$_GET['id'];
  $username_server="root";
  $database="task1DB";
  $password_server="";
  $server="localhost";
  $conn=new mysqli($server, $username_server, $password_server, $database);
  $sql=" SELECT * FROM Codes WHERE uniqueid = "."'".$uniqid."'"."AND expirydate > NOW()";
  $result=$conn->query($sql);
  $row=$result->fetch_assoc();
  if(isset($row['code']))
    echo $row['code'];
  else
    echo "Your code has expired";
  }
?></code></pre>
</html>

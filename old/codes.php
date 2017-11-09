<?php
session_start();
$uniqid="";
$code="";
if($_SERVER['REQUEST_METHOD']=="POST"){
    $code=htmlspecialchars($_POST['code']);
    saveCode($code);
}
function saveCode($data){
    $username_server="root";
    $database="task1DB";
    $password_server="";
    $server="localhost";
    $conn=new mysqli($server, $username_server, $password_server, $database);
    do{
        $uniqid=new_unique_id(12);
        $sql="SELECT * FROM Codes WHERE uniqueid = '" . $uniqid ."'";
        $result=$conn->query($sql);
    }while($result->num_rows!=0);
    $date=strtotime(strtr(trim($_POST['datetime']),"T"," "));
    $date=date("Y-m-d H:i",$date).":00";
    if($_POST['datetime']==""){
        $date="3000-12-12 12:12:00";
    }
    $binder=$conn->prepare("INSERT INTO Codes (uniqueid,username,code,expirydate) VALUES (? , ? , ?, ?)");
    $binder->bind_param("ssss",$uniqid,$_SESSION['username'],$data,$date);
    $binder->execute();
    $_SESSION['id']=$uniqid;
    $_SESSION['codeid']=$uniqid;
    header('Location: '.$uniqid);
}
function new_unique_id($intger){
    return bin2hex(openssl_random_pseudo_bytes(12));
}
?>
<html>
  <body>
    <textarea name="name" rows="30" cols="100"><?php echo $uniqid?></textarea>
  </body>
</html>

<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("db.php"); 
session_start();
if(!isset($_SESSION['email'])) {
    die("Sie sind nicht eingeloggt!");
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html> 
<html> 
<head>
  <meta charset="UTF-8">
  <title>Postfach</title>  
</head> 
<body>

<?php

/*$sql = "SELECT * FROM emails WHERE empfaenger = '$email'";
foreach ($pdo->query($sql) as $row){
  echo $row['absender']."<br>".$row['betreff']."<br> <br>";
}*/

$sql = "SELECT * FROM emails WHERE empfaenger = '$email'";
foreach ($pdo->query($sql) as $row){
  $absender = $row['absender'];
  $cmd = "SELECT * FROM users WHERE email = '$absender'";
  foreach ($pdo->query($cmd) as $inf){
    echo $inf['vorname']." ".$inf['nachname']."<br>";
  }
  echo $row['betreff']."<br> <br>";
}

?>


</body>
</html>
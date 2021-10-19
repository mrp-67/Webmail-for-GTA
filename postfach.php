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
  <style>  
    div {
      background: gold;
      width: 20%;
      height: 20vh;
      margin: 10vh;
    }

    div:hover {
      background: red;
    }
  
  </style> 
</head> 
<body>

<?php

/*$sql = "SELECT * FROM emails WHERE empfaenger = '$email'";
foreach ($pdo->query($sql) as $row){
  echo $row['absender']."<br>".$row['betreff']."<br> <br>";
}*/

//Mail overview
$sql = "SELECT * FROM emails WHERE empfaenger = '$email'";
foreach ($pdo->query($sql) as $row){
  $absender = $row['absender'];
  $eid = $row['eid'];
  
  $cmd = "SELECT * FROM users WHERE email = '$absender'";
  foreach ($pdo->query($cmd) as $inf){
    echo "<div><button>".$inf['vorname']." ".$inf['nachname']."<br>";
    $absenderVorname = $inf['vorname'];
    $absenderNachname = $inf['nachname'];
  }
  echo $row['betreff']."<br>";
  $absenderBetreff = $row['betreff']."</button></div>";
}
if(isset($_GET['eid'])) {
  echo "Das ist die EMAil ".$eid;
}

?>


</body>
</html>
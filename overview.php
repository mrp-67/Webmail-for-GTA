<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<?php
header("Content-Type: text/html; charset=utf-8");
require_once("db.php");
session_start();

$absender = $_SESSION['email'];
if(!isset($_SESSION['email'])) {
  die("Sie sind nicht eingeloggt!");
}

$sql = "SELECT * FROM users WHERE email = '$absender'";
$user = $pdo->query($sql)->fetch();
echo "Hallo, "; echo $user['vorname']." ".$user['nachname']."<br/>";

if($showFormular) {
?>

<form method='GET' action='absenden.php'>
  <input type='submit' value='E-Mail schreiben'>
</form>
<form method='GET' action='postfach.php'>
  <input type='submit' value='Postfach'> 
</form>

<form method='GET' action='logout.php'>
  <input type='submit' value='Ausloggen'> 
</form>

<?php
} //showformular


?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
body {
  margin: 0;
    font-family: arial;
}

.mailbox {
  background: #3e3e3e;
    width: 100%;
    height: 12vh;
    position: revert;
    display: flex;
}

.schreiben {
  width: 40vh;
    height: 6vh;
    font-size: 3vh;
}

.postfach {
  width: 40vh;
    height: 6vh;
    font-size: 3vh;
}

h2 {
  color: white;
    display: grid;
    position: fixed;
    right: 1%;
    font-size: 1.6vh;
    margin: 4.8vh 1vh;
}

input {
  background-color: #3e3e3e;
  color: white;
  border: 0;
  border-radius: 20vh;
}

input:hover {
  background-color: #323232;
  color: white;
}

</style>
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
echo "<h2> Hallo, "; echo $user['vorname']." ".$user['nachname']."</h2>";

if($showFormular) {
?>

<div class="mailbox">


<div>

    <form method='GET' action='absenden.php'>
      <input class="schreiben" type='submit' value='E-Mail schreiben'>
    </form>

    <form method='GET' action='postfach.php'>
      <input class="postfach" type='submit' value='Postfach'> 
    </form>

</div>

<div>

    <form method='GET' action='logout.php'>
      <input class="ausloggen" type='submit' value='Ausloggen'> 
    </form>

</div>
  
</div>







<?php
} //showformular


?>
</body>
</html>
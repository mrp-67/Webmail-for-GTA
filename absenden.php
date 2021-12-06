<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nositelinkssearchbox, nopagereadaloud, notranslate" />
<meta charset="UTF-8">
<title>Absenden</title>
<style>
  body {
    margin: 0;
    font-size: 2vh;
    font-family: arial;
    background-color: #424242;
    color: white;
  }

  .texts {
    display: flex;
  }

  .hallo {
    width: 12vh;
    text-align: end;
    padding-right: 2vh;
  }

  .mailtext {
    width: 100%;
    border: 0;
    background-color: #424242;
    font-size: 2vh;
    color: white;
    padding: 2vh;
  }

  .betrefftext {
    width: 100%;
    border: 0;
    background-color: #424242;
    font-size: 2vh;
    padding: 2vh;
    color: white;
  }

  .nachrichttext {
    width: 90%;
    height: 70vh;
    border: 0px;
    background-color: rgb(58, 58, 58);
    font-size: 2vh;
    color: white;
    padding: 2vh;
    margin: 0px;
  }

  .bittonn {
    width: 20vh;
    height: 4vh;
    position: absolute;
    right: 2vh;
    background: #066200;
    border: 0;
    border-radius: 5px;
    color: white;
  }

  .ppp {
    position: absolute;
    left: 4vh;
    bottom: 0vh;
  }
</style> 
</head>
<body>

<?php
header("Content-Type: text/html; charset=utf-8");
header("Refresh:600");
require_once("db.php"); 
require_once("functions.php");
session_start();

if(!isset($_SESSION['email'])) {
  die('Sie sind nicht eingeloggt! <meta http-equiv="refresh" content="1; URL=index.php">');
}
$absender = $_SESSION['email'];

if(isset($_GET['absenden'])) {
  $empfaenger = $_POST['empfaenger'];
  $betreff = $_POST['betreff'];
  $message = nl2br($_POST['message']);
  $error = false;

  if($absender == $empfaenger){
    echo '<p class="ppp">Sie dürfen an sich selber keine EMails versenden.</p>';
    $error = true;
  }
  elseif(strlen($empfaenger) == 0) {
    echo '<p class="ppp">Bitte geben Sie den Empfänger ein.</p>';
    $error = true;
  }    
  elseif(strlen($betreff) == 0) {
    echo '<p class="ppp">Bitte geben Sie ein Betreff ein.</p>';
    $error = true;
  }    
  elseif(strlen($message) == 0) {
    echo '<p class="ppp">Sie dürfen keine leere E-Mails versenden.</p>';
    $error = true;
  }

  if(!$error) { 
    $empfaenger = $_POST['empfaenger'];
    $betreff = $_POST['betreff'];
    $message = nl2br($_POST['message']);
    $statement = $pdo->prepare("INSERT INTO emails (absender, empfaenger, betreff, nachricht) VALUES (:absender, :empfaenger, :betreff, :nachricht)");
    $result = $statement->execute(array('absender' => $absender, 'empfaenger' => $empfaenger, 'betreff' => $betreff, 'nachricht' => $message));

    if($result) {        
      $showFormular = false;
      echo 'Ihr EMail wurde erfolgreich versendet.<br>Sie werden weitergeleitet in 3 Sekunden.<meta http-equiv="refresh" content="3; URL=postfach.php">';
    }else {
      echo 'Ihr EMail konnte nicht zugestellt werden, probieren Sie es bitte zu einem anderen Zeitpunkt nochmal.<meta http-equiv="refresh" content="3; URL=postfach.php"> <br>';
    }

  }
}
if($showFormular) {
?>



<div><p></p><form class="contact-form" action="?absenden" method="post"></div>
<div class="texts"><p class="hallo">Mail :</p><input class="mailtext" type="text" name="empfaenger" placeholder="Mail"></div>
<div class="texts"><p class="hallo">Betreff :</p><input class="betrefftext" type="text" name="betreff"  placeholder="Betreff"></div>
<div class="texts"><p class="hallo">Nachricht :</p><textarea class="nachrichttext" name="message" max="1024" placeholder="Nachricht"> </textarea></div>
<div><p></p><button class="bittonn" type="submit" value="Absenden">Absenden</button></div>
</form></div>

<form method='GET' action='postfach.php'>
  <input class="abbrechen" type='submit' value='Abbrechen'>
</form>

<?php
}
?>

</body>
</html>
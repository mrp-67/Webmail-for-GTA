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

if(isset($_GET['absenden'])) {
 
  $empfaenger = $_POST['empfaenger'];
  $betreff = $_POST['betreff'];
  $message = $_POST['message'];

  $statement = $pdo->prepare("INSERT INTO emails (absender, empfaenger, betreff, nachricht) VALUES (:absender, :empfaenger, :betreff, :nachricht)");
  $result = $statement->execute(array('absender' => $absender, 'empfaenger' => $empfaenger, 'betreff' => $betreff, 'nachricht' => $message));

  if(strlen($empfaenger) == 0) {
    echo '<div><p>Bitte geben Sie den Empfänger ein.<p></div><br>';
    $error = true;
  }    
  elseif(strlen($betreff) == 0) {
    echo '<div><p>Bitte geben Sie ein Betreff ein.<p></div><br>';
    $error = true;
  }    
  elseif(strlen($nachname) == 0) {
  echo '<div><p>Sie dürfen keine leere E-Mails versenden.<p></div><br>';
  $error = true;
  }  

  if($result) {        
    $showFormular = false;
    echo 'Ihr EMail wurde erfolgreich versendet.<br>Sie werden weitergeleitet in 3 Sekunden.<meta http-equiv="refresh" content="5; URL=overview.php">';
  } else {
  echo 'Ihr EMail konnte nicht zugestellt werden, probieren Sie es bitte zu einem anderen Zeitpunkt nochmal.<meta http-equiv="refresh" content="5; URL=overview.php"> <br>';
  }

}

?>

<form class="contact-form" action="?absenden" method="post">
<input type="text" name="empfaenger">
<input type="text" name="betreff">
<textarea name="message" placeholder="Nachricht"> </textarea>
<button type="submit" value="Absenden">
</form>

</body>
</html>
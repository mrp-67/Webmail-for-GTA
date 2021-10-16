<!DOCTYPE html>
<html>
<body>

<?php
require_once("db.php"); 
session_start();

if(isset($_GET['absenden'])) {
 
  $absender = $_SESSION['email'];
  $empfaenger = $_POST['empfaenger'];
  $betreff = $_POST['betreff'];
  $message = $_POST['message'];

  $statement = $pdo->prepare("INSERT INTO emails (absender, empfaenger, betreff, nachricht) VALUES (:absender, :empfaenger, :betreff, :nachricht)");
  $result = $statement->execute(array('absender' => $absender, 'empfaenger' => $empfaenger, 'betreff' => $betreff, 'nachricht' => $message));

  if($result) {        
    $showFormular = false;
    echo 'Ihr EMail wurde erfolgreich versendet.<br>Sie werden weitergeleitet in 3 Sekunden.<meta http-equiv="refresh" content="5; URL=http://localhost:8080/webmail/webmail/index.php">';
  } else {
  echo 'Ihr EMail konnte nicht zugestellt werden, probieren Sie es bitte zu einem anderen Zeitpunkt nochmal.<meta http-equiv="refresh" content="5; URL=http://localhost:8080/webmail/webmail/index.php"> <br>';
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
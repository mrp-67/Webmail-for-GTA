<!DOCTYPE html>
<html>
<body>

<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=webmail', 'root', '');

if(isset($_GET['absenden'])) {
 
  $absender = $_SESSION['email'];
  $empfaenger = $_POST['empfaenger'];
  $betreff = $_POST['betreff'];
  $message = $_POST['message'];

  $statement = $pdo->prepare("INSERT INTO emails (absender, empfaenger, betreff, nachricht) VALUES (:absender, :empfaenger, :betreff, :nachricht)");
  $result = $statement->execute(array('absender' => $absender, 'empfaenger' => $empfaenger, 'betreff' => $betreff, 'nachricht' => $message));

}



?>

<form class="contact-form" action="?absenden=1" method="post">
<input type="text" name="empfaenger">
<input type="text" name="betreff">
<textarea name="message" placeholder="Nachricht"> </textarea>
<button type="submit" value="Absenden">
</form>

</body>
</html>
<!DOCTYPE html>
<html>
<body>

<?php
require_once("db.php"); 
if($showFormular) {
?>

<form method='GET' action='http://localhost:8080/webmail/webmail/login.php'>
  <input type='submit' value='Login'>
</form>
<form method='GET' action='http://localhost:8080/webmail/webmail/register.php'>
  <input type='submit' value='Registrieren'>
</form>
<form method='GET' action='http://localhost:8080/webmail/webmail/absenden.php'>
  <input type='submit' value='E-Mail schreiben'>
</form>
<form method='GET' action='http://localhost:8080/webmail/webmail/postfach.php'>
  <input type='submit' value='Postfach'> 
</form>

<?php
} //showformular
?>
</body>
</html>
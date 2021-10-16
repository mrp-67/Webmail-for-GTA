<?php 
require_once("db.php"); 
session_start();
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Registrierung</title>    
</head> 
<body>
 
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    //$email = $email . "@reality.de";
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }     
    if(strlen($firstname) == 0) {
        echo 'Bitte geben Sie ihre Vornamen ein.<br>';
        $error = true;
    }

    if(strlen($lastname) == 0) {
        echo 'Bitte geben Sie ihre Nachname ein.<br>';
        $error = true;
    }

    if(strlen($passwort) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }

    if($passwort != $passwort2) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        
        $statement = $pdo->prepare("INSERT INTO users (email, passwort, firstname, lastname) VALUES (:email, :passwort, :firstname, :lastname)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'firstname' => $firstname, 'lastname' => $lastname));
        
        if($result) {        
            echo 'Sie haben erfolgreich ihren E-Mail-Konto registriert.<br>Sie werden automatisch weitergeleitet<meta http-equiv="refresh" content="3; URL=login.php">';
            $showFormular = false;
        } else {
            echo 'Bei der Registrierung ist ein Fehler aufgetreten<br>';
        }
    } 
}
 
if($showFormular) {
?>
 
<form action="?register=1" method="post">
    Name:<br>
    <input type="text" size="40" maxlength="250" name="firstname"><br>
    Nachname:<br>
    <input type="text" size="40" maxlength="250" name="lastname"><br>
    E-Mail:<br>
    <input type="email" size="40" maxlength="250" name="email"><br><br>
    Dein Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort"><br>
    Passwort wiederholen:<br>
    <input type="password" size="40" maxlength="250" name="passwort2"><br><br>
    <input type="submit" value="Ich stimme zu. Jetzt E-Mail-Konto anlegen.">
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>
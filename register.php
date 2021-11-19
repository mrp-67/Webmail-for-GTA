<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("db.php"); 
session_start();
?>
<!DOCTYPE html> 
<html> 
<head>
<meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nositelinkssearchbox, nopagereadaloud, notranslate" />
  <meta charset="UTF-8">
  <title>Registrierung</title>  
  <style>
      body {
        margin: 0;
        display: grid;
        width: 100%;
        height: 100%;
      }

      .form {
        margin: auto;
        margin-top: 18%;
        display: grid;
      }

      .text {
        width: 26vh;
        height: 3vh;
        text-align: center;
        margin: 1vh auto;
      }

      .email {
        width: 26vh;
        height: 3vh;
        text-align: center;
        margin: 1vh auto;
      }

      .password {
        width: 26vh;
        height: 3vh;
        text-align: center;
        margin: 1vh auto;
      }

      .submit {
        margin: 3vh auto;
        display: flex;
        font-size: 2vh;
        padding: 1vh 6vh;
        border: 0;
        background: #ffc107;
        border-radius: 5px;
      }

      .div {
        background: #ffc107;
        height: auto;
        width: auto;
        margin: auto;
        display: flex;
        margin-top: 12vh;
        position: fixed;
        border-radius: 5px;
      }

      p {
        text-align: center;
        width: auto;
        height: auto;
        padding: 0.6vh 4vh;
        color: #ff0000;
        font-size: 20px;
        margin: 0;
        font-family: arial;
      }

      .realitymail {
        text-align: center;
        width: 50vh;
        height: auto;
        padding: 0.6vh 4vh;
        color: black;
        font-size: 15px;
        margin: 2vh 0px 0px 0px;
        font-family: arial;
      }

      a {
        color: #0037ff;
      }

  </style>  
</head> 
<body>
 
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'] . "@reality.rp";
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];
    $ip = $_SERVER["REMOTE_ADDR"];
  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div><p>Bitte eine gültige E-Mail-Adresse eingeben<p></div><br>';
        $error = true;
    }    
    elseif(strlen($vorname) == 0) {
      echo '<div><p>Bitte geben Sie ihre Vorname an.<p></div><br>';
      $error = true;
    }
    elseif(strlen($nachname) == 0) {
      echo '<div><p>Bitte geben Sie ihre Nachname an.<p></div><br>';
      $error = true;
    }  
    elseif(strlen($passwort) == 0) {
      echo '<div><p>Bitte ein Passwort angeben<p></div><br>';
      $error = true;
    }
    elseif($passwort != $passwort2) {
      echo '<div><p>Die Passwörter müssen übereinstimmen<p></div><br>';
      $error = true;
    }
    
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) { 
        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();
        
        if($user !== false) {
            echo '<div><p>Diese E-Mail-Adresse ist bereits vergeben<p></div><br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {    
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);
        
        $statement = $pdo->prepare("INSERT INTO users (email, passwort, vorname, nachname, ip) VALUES (:email, :passwort, :vorname, :nachname, :ip)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash, 'vorname' => $vorname, 'nachname' => $nachname, 'ip' => $ip));
        
        if($result) {        
            echo '<div><p>Sie haben ihr E-Mail-Konto erfolgreich angelegt.<br>Sie werden in 3 Sekunden automatisch weitergeleitet. <meta http-equiv="refresh" content="3; URL=index.php"><br>';
            $showFormular = false;
        } else {
            echo '<div><p>Beim Abspeichern ist leider ein Fehler aufgetreten<p></div><br>';
        }
    } 
}
 
if($showFormular) {
?>
 
<form class="form" action="?register=1" method="post">
    <div>
      <input class="text" type="text" size="40" maxlength="250" name="vorname" placeholder="Vorname">
      <input class="text" type="text" size="40" maxlength="250" name="nachname" placeholder="Nachname">
    </div>

    <div>
      <input class="email" type="text" size="40" maxlength="250" name="email" placeholder="E-Mail">
      <p>1vh</p>
    </div>

    <div>
    <input class="password" type="password" size="40"  maxlength="250" name="passwort" placeholder="Passwort">
    <input class="password" type="password" size="40" maxlength="250" name="passwort2" placeholder="Passwort">
    </div>
    
    <input class="submit" type="submit" value="Ich stimme zu. Jetzt E-Mail-Konto anlegen.">
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>
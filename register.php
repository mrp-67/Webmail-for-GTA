<?php 
require_once("db.php"); 
session_start();
?>
<!DOCTYPE html> 
<html> 
<head>
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
        margin-top: 23%;
      }

      .email {
        width: 26vh;
        height: 3vh;
        text-align: center;
        margin: 1vh 0;
      }

      .password {
        width: 26vh;
        height: 3vh;
        text-align: center;
        margin: 1vh 0;
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

      div {
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
  </style> 
</head> 
<body>
 
<?php
$showFormular = true; //Variable ob das Registrierungsformular anezeigt werden soll
 
if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    $passwort2 = $_POST['passwort2'];
  
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div>Bitte eine gültige E-Mail-Adresse eingeben</div>';
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
        
        $statement = $pdo->prepare("INSERT INTO users (email, passwort) VALUES (:email, :passwort)");
        $result = $statement->execute(array('email' => $email, 'passwort' => $passwort_hash));
        
        if($result) {        
            echo 'Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
 
if($showFormular) {
?>
 
<form class="form" action="?register=1" method="post">
    <br>
    <input class="email" type="email" size="40" maxlength="250" name="email" placeholder="E-Mail">
    
    <br>
    <input class="password" type="password" size="40"  maxlength="250" name="passwort" placeholder="Passwort">
    
    <br>
    <input class="password" type="password" size="40" maxlength="250" name="passwort2" placeholder="Passwort"><br>
    
    <input class="submit" type="submit" value="Abschicken">
</form>
 
<?php
} //Ende von if($showFormular)
?>
 
</body>
</html>
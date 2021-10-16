<?php 
require_once("db.php"); 
session_start();
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['email'] = $email;
        die('Sie haben sich erfolgreich Angemeldet. <br>Sie werden automatisch weitergeleitet<meta http-equiv="refresh" content="3; URL=overview.php">');
    } else {
        $errorMessage = "E-Mail oder Passwort ist ungültig.<br>";
    }
    
}
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Login</title>  
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
if(isset($errorMessage)) {
    echo $errorMessage;
}
if($showFormular) {
?>
<form class="form" action="?login=1" method="post">
    
    <br>
    
    <input class="email" type="email" size="40" maxlength="250" name="email" placeholder="E-Mail">
    
    <br>
    
    <input class="password" type="password" size="40"  maxlength="250" name="passwort" placeholder="Passwort"><br>
    
    <input class="submit" type="submit" value="Login">

</form> 
<?php
} //showformular
?>
</body>
</html>
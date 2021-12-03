<?php 
header("Content-Type: text/html; charset=utf-8");

require_once("db.php"); 
session_start();

if(isset($_SESSION['email'])) {
  echo '<div> Sie sind bereits angemeldet.<br>Sie werden weitergeleitet. </div> <meta http-equiv="refresh" content="3; URL=postfach.php">';
  $showFormular = false;
}

if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['email'] = $email;
        die('<div> Sie haben sich erfolgreich Angemeldet. <br>Sie werden automatisch weitergeleitet </div> <meta http-equiv="refresh" content="1; URL=postfach.php">');
    } else {
        $errorMessage = "<div><p>E-Mail oder Passwort ist ungültig.</p></div><br>";
    }
    
}

?>
<!DOCTYPE html> 
<html> 
<head>
<meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nositelinkssearchbox, nopagereadaloud, notranslate" />
<meta charset="UTF-8">
  <title>Login</title>  
  <style>

    body{
      margin: 0;
      display: grid;
      width: 100%;
      height: 100%;
      background-color: #424242;
      font-family: arial;
      color: white;
    }

    .form{
      margin: auto;
    }

    .email{
      width: 35vh;
      height: 5vh;
      text-align: center;
      margin: 1vh 0;
      border: 0;
      border-radius: 5px;
      font-size: 2vh;
    }

    .password{
      width: 35vh;
      height: 5vh;
      text-align: center;
      margin: 1vh 0;
      border: 0;
      border-radius: 5px;
      font-size: 2vh;
    }

    .submit{
      margin: 3vh auto;
      display: flex;
      font-size: 2vh;
      padding: 1vh 6vh;
      border: 0;
      background: #ffc107;
      border-radius: 5px;
    }

    div{
      height: auto;
      width: auto;
      margin: auto;
      display: flex;
      margin-top: 12vh;
      border-radius: 5px;
      position: initial;
      justify-content: center;
    }

    p{
      text-align: center;
      width: auto;
      height: auto;
      padding: 1vh 4vh;
      color: #ff0000;
      font-size: 20px;
      margin: -2vh;
      font-family: arial;
      background: #ffc107;
      border-radius: 5px;
    }

    .mrp67{
      text-align: center;
      width: 100%;
      text-decoration-line: blink;
      color: #ffc107;
    }

    .logo{
      width: 30vh;
      height: auto;
    }

  </style>  
</head> 
<body>
 
<?php 
if(isset($errorMessage)){
    echo $errorMessage;
}
  if($showFormular){
?>

<form class="form" action="?login=1" method="post">
  <div> <img class="logo" src="img/logo.png" alt="logo"> </div>
  <br> <input class="email" type="email" size="40" maxlength="250" name="email" placeholder="Nutzername"> <br>
  <input class="password" type="password" size="40"  maxlength="250" name="passwort" placeholder="Passwort"><br>
  <input class="submit" type="submit" value="Login">
  <div style="margin-top: 3vh;"> <a href="register.php" class="mrp67"> <font style="font-size: 1.5vh;" size="-2">Kostenlos registrieren!</font> </a> </div>
</form> 

<?php
  } //showformular
?>
</body>
</html>
<?php 
include("password.php");
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=webmail', 'root', '');
 
if(isset($_GET['login'])) { 
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['email'] = $email;
        die('Login erfolgreich. Weiter zu <a href="absenden.html">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
}
?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Login</title>
</head> 
<body>
 
<?php 
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>

</form> 
</body>
</html>
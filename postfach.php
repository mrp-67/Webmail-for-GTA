<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=webmail', 'root', '');
 
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    


    
}
?>
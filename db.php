<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=webmail', 'root', '');
    $showFormular =true;
  } catch (Exception $error) {
    echo 'Es ist ein fehler aufgetreten: ',  $error->getMessage(), "\n";
    $showFormular = false;
  }
?>
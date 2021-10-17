<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=webmail', 'root', '',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $showFormular =true;
  } catch (Exception $error) {
    echo 'Es ist ein fehler aufgetreten: ',  $error->getMessage(), "\n";
    $showFormular = false;
  }
?>
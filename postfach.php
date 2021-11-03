<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("db.php"); 
session_start();
if(!isset($_SESSION['email'])) {
    die("Sie sind nicht eingeloggt!");
}
$email = $_SESSION['email'];
?>
<!DOCTYPE html> 
<html> 
<head>
  <meta charset="UTF-8">
  <title>Postfach</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>  

    body {
      display: flex;
      margin: 0;
      color: white;
      font-family: arial;
    }

    .mailbox {
      width: 30vh;
      height: 100vh;
      background-color: #424242;
    }

    .schreiben {
      width: 30vh;
      height: 10vh;
      border: 0;
      background-color: #424242;
      font-size: 3vh;
      color: white;
    }

    .schreiben:hover {
      background-color: #565656;
    }

    .ausloggen {
      width: 30vh;
      height: 10vh;
      border: 0;
      background-color: #424242;
      font-size: 3vh;
      color: white;
    }

    .ausloggen:hover {
      background-color: #565656;
    }

    .hallo {
      width: 30vh;
      height: 8vh;
      border-bottom: inset;
      border-bottom-color: black;
      border-bottom-width: 1px;
    }

    .hallo:hover {
      background: #343434;
    }

    .test {
      position: absolute;
      width: 30vh;
      height: 8vh;
      background: transparent;
      border: 0;
      margin: -2vh;
    }

    .boxx {
      padding: 2vh;
    }

    .absender {
      width: 100%;

    }

    .von {
      background-color: #424242;
      height: 10vh;
    }

    .delete {
      position: absolute;
      right: 2vh;
    }

    .nachricht {
      background: #2e2e2e;
      height: 87.3vh;
      padding: 2.7vh 0 0 2.7vh;
      font-size: 2vh;
    }

    .ichbin {
      padding: 2.7vh;
      font-size: 2vh;
    }

    b {
      margin: 0 0 0 2vh;
    }
      
  </style> 
</head> 
<body>

<div class="mailbox">

    <form method='GET' action='absenden.php'>
      <input class="schreiben" type='submit' value='Verfassen '>
    </form>

    <form method='GET' action='logout.php'>
      <input class="ausloggen" type='submit' value='Ausloggen'> 
    </form>
  
</div>


<div style="background: #2e2e2e;    font-size: 1.8vh;">
<?php

/*$sql = "SELECT * FROM emails WHERE empfaenger = '$email'";
foreach ($pdo->query($sql) as $row){
  echo $row['absender']."<br>".$row['betreff']."<br> <br>";
}*/

//get emails from db for overview
$sql = "SELECT emails.eid, emails.absender, emails.betreff FROM emails WHERE empfaenger = '$email' ORDER BY eid DESC";
foreach ($pdo->query($sql) as $row){
  $absender = $row['absender'];
  $eid = $row['eid'];
 
  $cmd = "SELECT users.vorname, users.nachname FROM users WHERE email = '$absender'";
  foreach ($pdo->query($cmd) as $inf){
    //*echo "".$inf['vorname']." ".$inf['nachname']."<br>"; 
    echo "<div class='hallo'><form class='boxx' action='?register=$eid' method='post'><input class='test' value='' type='submit' name='eid'>".$inf['vorname']." ".$inf['nachname']."<br>".$row['betreff']."<br></form></div>"; 
  }

  $absenderBetreff = $row['betreff'];
}
?>
</div>

<div class="absender">
<?php

//get email from db
if(isset($_GET['register'])) {
  $meid = $_GET['register'];
  $msql = "SELECT users.vorname, users.nachname, users.email, emails.nachricht, emails.betreff FROM emails, users WHERE eid = '$meid' AND users.email = emails.absender";
  $nuser = $pdo->query($msql)->fetch();
  
  echo "<div class='von'><div class='ichbin'><b>Von: </b>".$nuser['vorname']." ".$nuser['nachname']." &lt;".$nuser['email']."&gt; <form action='?loeschen=$meid' method='post'> <input class='delete' type='submit' name='loeschen' value='Löschen' ><div> Betreff: ".$nuser['betreff']."</div></div></div><div class='nachricht'>".$nuser['nachricht']."</div>";

  //*echo "<form action='?loeschen=$meid' method='post'><input type='submit' name='loeschen' value='Löschen'> </form>"; //frage für mrp67 bitte mit aipo reden danke 

}

if(isset($_GET['loeschen'])) {
  $meid = $_GET['loeschen'];

  $lmsql = "DELETE FROM emails WHERE eid=?";
  $cmd= $pdo->prepare($lmsql);
  $cmd->execute([$meid]);

  echo 'E-Mail wurde gelöscht! <meta http-equiv="refresh" content="1; URL=postfach.php">';
}
?>
</div>

</body>
</html>
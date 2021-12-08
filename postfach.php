<?php 
header("Content-Type: text/html; charset=utf-8");
header("Refresh:300");
require_once("db.php");

session_start();
if(!isset($_SESSION['email'])) {
  die('Sie sind nicht eingeloggt! <meta http-equiv="refresh" content="1; URL=index.php">');
  $showFormular = false;
}
$email = $_SESSION['email'];
require_once("functions.php");

?>
<!DOCTYPE html> 
<html> 
<head>
<meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nositelinkssearchbox, nopagereadaloud, notranslate" />
  <meta charset="UTF-8">
  <title>Postfach</title>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>  

    body{
      display: flex;
      margin: 0;
      color: white;
      font-family: arial;
      background-color: #424242;
    }

    .mailbox{
      width: 30vh;
      height: 100vh;
      background-color: #424242;
    }

    .schreiben{
      width: 20vh;
      height: 5vh;
      border: 0;
      background-color: #424242;
      font-size: 2vh;
      color: white;
    }

    .schreiben:hover{
      background-color: #565656;
    }

    .ausloggen{
      width: 20vh;
      height: 5vh;
      border: 0;
      background-color: #424242;
      font-size: 2vh;
      color: white;
    }

    .ausloggen:hover{
      background-color: #565656;
    }

    .refresh{
      width: 20vh;
      height: 5vh;
      border: 0;
      background-color: #424242;
      font-size: 2vh;
      color: white;
      bottom : 0%;
      position: absolute;
    }

    .refresh:hover{
      background-color: #565656;
    }

    .hallo{
      width: 30vh;
      height: 8vh;
      border-bottom: inset;
      border-bottom-color: black;
      border-bottom-width: 1px;
    }

    .hallo:hover{
      background: #343434;
    }

    .test{
      position: absolute;
      width: 30vh;
      height: 8vh;
      background: transparent;
      border: 0;
      margin: -2vh;
    }

    .boxx{
      padding: 2vh;
    }

    .absender{
      width: 100%;
    }

    .von{
      background-color: #424242;
      height: 8vh;
      border-bottom: inset;
      border-bottom-color: black;
      border-bottom-width: 1px;
    }

    .delete{
      position: absolute;
      right: 2vh;
      background-color: transparent;
      color: white;
      font-size: 2vh;
      border: solid;
      border-radius: 0.5vh;
      padding: 0.5vh;
      top: 2vh;
    }

    .delete:hover {
      background-color: #565656;
    }

    .nachricht{
      background: #2e2e2e;
      height: 89.2vh;
      padding: 2.7vh 0 0 2.7vh;
      font-size: 2vh;
    }

    .ichbin{
      padding: 1.7vh;
      font-size: 2vh;
    }
      
  </style> 
</head> 
<body>

<?php
  if($showFormular){
?>

<div class="mailbox">

    <form method='GET' action='absenden.php'>
      <input class="schreiben" type='submit' value='Verfassen'>      
    </form>

    <form method='GET' action='logout.php'>
      <input class="ausloggen" type='submit' value='Ausloggen'> 
    </form>

    <form method='GET' action='postfach.php'>
      <input class="refresh" type='submit' value='Aktualisieren'> 
    </form>
  
</div>

<div style="background: #2e2e2e;  font-size: 1.8vh; border-right: inset;  border-right-color: black;  border-right-width: 1px;">
<?php

//get emails from db for overview
$sql = "SELECT emails.eid, emails.absender, emails.betreff FROM emails WHERE empfaenger = '$email' ORDER BY eid DESC";
foreach ($pdo->query($sql) as $row){
  $absender = $row['absender'];
  $eid = $row['eid'];
  $cmd = "SELECT users.vorname, users.nachname FROM users WHERE email = '$absender'";
  foreach ($pdo->query($cmd) as $inf){
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
  unsetSessions();
  $meid = $_GET['register'];
  $msql = "SELECT users.vorname, users.nachname, users.email, emails.nachricht, emails.betreff, emails.created_at FROM emails, users WHERE eid = '$meid' AND users.email = emails.absender";
  $nuser = $pdo->query($msql)->fetch();
  
  $_SESSION['answerEmail'] = $nuser['email'];
  $_SESSION['answerBetreff'] = "Re: " . $nuser['betreff'];
  $_SESSION['answerNachricht'] = "Am " . $nuser['created_at'] . " schrieb " . $nuser['vorname'] . " " . $nuser['nachname'] . ": 
  ". $nuser['nachricht'];

  echo "<div class='von'><div class='ichbin'><b>Von: </b>".$nuser['vorname']." ".$nuser['nachname']." &lt;".$nuser['email']."&gt; <form action='?loeschen=$meid' method='post'> <input class='delete' type='submit' name='loeschen' value='Löschen'> </form> <div> Betreff: ".$nuser['betreff']."</div></div></div><div class='nachricht'>".$nuser['nachricht']."</div>";
  echo "<form action='absenden.php?answer=1' method='post'><input type='submit' name='answer' value='Antworten'> </form>";

}

if(isset($_GET['loeschen'])) {
  $meid = $_GET['loeschen'];
  $lmsql = "DELETE FROM emails WHERE eid=?";
  $cmd= $pdo->prepare($lmsql);
  $cmd->execute([$meid]);

  echo 'E-Mail wurde gelöscht! <meta http-equiv="refresh" content="1; URL=postfach.php">';
}
?>
<?php
  } //showFormular
?>

</div>

</body>
</html>
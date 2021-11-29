<?php 
header("Content-Type: text/html; charset=utf-8");
require_once("db.php"); 
session_start();

if(!isset($_SESSION['email'])) {
  die("Sie sind nicht eingeloggt!");
}
?>
<!DOCTYPE html> 
<html> 
<head>
<meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nositelinkssearchbox, nopagereadaloud, notranslate" />
  <meta charset="UTF-8">
  <title>Verifizieren</title>  
  <style>

  </style>  
</head> 
<body>

<?php
if(isset($_GET['verify'])) {
    $error = false;
    $steamhex = $_POST['steamid'];
    if(strlen($steamhex) == 0) {
        echo '<div><p>Bitte geben Sie ihre SteamHex ein.<p></div><br>';
        $error = true;
    }
    
    $steamid = "steam:" . $steamhex;
            
    if(!$error){
        $suche = array($steamid);
        $players = strip_tags(file_get_contents('http://launcher.mrp67.de:30120/players.json'));
            
        foreach($suche as $value){
            if(stripos($players, $value) !== false){
                echo "Sie sind gerade Online.";
            }
            else{
                echo "Sie sind Offline oder die Angegebene SteamHex stimmt nicht!";
            }
        } 

    }
     
}

?>
<form class="form" action="?verify=1" method="post">
    <div>
      <input class="text" type="text" size="40" maxlength="250" name="steamid" placeholder="STEAMID64">
    </div>

    <input class="submit" type="submit" value="Verifizieren">
</form>

</body>
</html>
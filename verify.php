<?php

$url="http://rp.night-v.org:30120/players.json'";
$check = @fsockopen($url, 80);
If ($check) {
  if(isset($_SESSION['email'])){
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $user = $pdo->query($sql)->fetch();
    $status = $user['status'];
      if($status == 1)
      {
        $showFormular = false;
        echo '<div>Ihr Konto wurde gesperrt, bitte melden Sie sich im Support.<br>Sie werden automatisch ausgeloggt.</div><meta http-equiv="refresh" content="5; URL=logout.php">';
      }
      elseif(isset($_SESSION['email'])){
          $sql = "SELECT * FROM users WHERE email = '$email'";
          $user = $pdo->query($sql)->fetch();
          $steamid = $user['steamid'];
  
          $suche = array($steamid);
          $players = strip_tags(file_get_contents('http://rp.night-v.org:30120/players.json'));
            
          foreach($suche as $value){
            if(stripos($players, $value) !== false){
            }
              else{
                $error = true;
                $showFormular = false;
                echo '<div> Sie sind nicht mit unserem Gameserver verbunden.<br> Sie werden automatisch ausgeloggt.</div><meta http-equiv="refresh" content="5; URL=logout.php">';
              }
          } 
      } 
  }

} Else {
  $showFormular = false;
  echo '<div>Unser Gameserver wird derzeit gewartet.<br> Mehr Informationen finden Sie auf unserem Discord-Server.</div><meta http-equiv="refresh" content="5; URL=logout.php">';
}

?>



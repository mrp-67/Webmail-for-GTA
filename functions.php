<?php
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

  function gameServerStatus(){

    $url = "rp.night-v.org:30120/players.json";
    $online = @fsockopen ($url, 30120);
    if (!$online) {
      $showFormular = false;
      $error = true;
      echo '<div>Unser Gameserver wird aktuell gewartet. Weitere Informationen finden Sie auf unserem <a href="https://discord.gg/vNDWcYc6qr"> Discord-Server.</a> </div><meta http-equiv="refresh" content="10; URL=https://night-v.org">';
    } else {
      }
  }
?>



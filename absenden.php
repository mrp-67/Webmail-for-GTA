<?php 
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=webmail', 'root', '');
 
$absenderemail = $_SESSION['email'];
echo "$absenderemail";

?>
<!DOCTYPE html> 
<html> 
<head>
  <title>Absenden</title>    
</head> 
<body>
 
<?php 

?>
 
</form> 
</body>
</html>
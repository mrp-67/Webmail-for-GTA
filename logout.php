<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>

<?php
header("Content-Type: text/html; charset=utf-8");
session_start();
session_destroy();
unset($_SESSION['email']);
echo 'Sie haben sich erfolgreich ausgeloggt!<meta http-equiv="refresh" content="1; URL=index.php">';
?>

</body>
</html>
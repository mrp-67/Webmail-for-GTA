<!DOCTYPE html>
<html>
<body>

<?php
session_start();
session_destroy();
unset($_SESSION['email']);
echo 'Sie haben sich erfolgreich ausgeloggt!<meta http-equiv="refresh" content="1; URL=index.php">';
?>

</body>
</html>
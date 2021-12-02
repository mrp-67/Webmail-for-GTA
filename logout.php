<!DOCTYPE html>
<html>
<head>
    <meta name="robots" content="noindex, nofollow, noimageindex, noarchive, nocache, nositelinkssearchbox, nopagereadaloud, notranslate" />
    <meta charset="UTF-8">
    <style>
        body{
            display: flex;
            margin: 0;
            color: white;
            font-family: arial;
            background-color: #424242;
        }

        div{
            height: auto;
            width: auto;
            margin: auto;
            display: flex;
            margin-top: 12vh;
            border-radius: 5px;
            position: initial;
        }
    </style>
</head>
<body>

    <?php
        header("Content-Type: text/html; charset=utf-8");
        session_start();
        session_destroy();
        unset($_SESSION['email']);
        echo '<div>Sie wurden erfolgreich ausgeloggt!</div> <meta http-equiv="refresh" content="3; URL=index.php">';
    ?>

</body>
</html>
<!DOCTYPE html>
<html lang="de">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css"
          integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.3.4/dist/leaflet.js"
            integrity="sha512-nMMmRyTVoLYqjP9hrbed9S+FzjZHW5gY1TWCHA5ckwXZBadntCNs8kEqAWdrb9O7rxbCaA4lKTIWjDXZxflOcA=="
            crossorigin=""></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/bootstrap-custom.css">
    <title>Sportclips</title>

</head>
<body id="bodyLogin" style="background-image:url(img/background.jpg)">
<form class="form-signin" name="formular" method="get" action="login.php">

    <h2>Sportclips Login</h2>
    <br><br>

    <?php
    error_reporting(0);

    if (isset($gast) == FALSE) {
            $gast = TRUE;
    }

    /* Überprüfung der Login-Daten */
    clearstatcache();
    session_start();
    $name = $_GET['inputName'];
    $password = password_hash($_GET['inputPassword'], PASSWORD_BCRYPT);

    $leseDatei = fopen("../Sportclips_Git/text/users.txt", "r");
    $test = fgetcsv($leseDatei, 1000, ",");
    if ($test[0] == $name && password_verify($test[1], $password)) {
        $gast = FALSE;
        header('Location: index.php');
    } else if ($name != "" && !password_verify("", $password)) {
        echo "Benutzername oder Passwort falsch!";
    }
    fclose($leseDatei);

    $_SESSION['gast'] = $gast;

    ?>

    <!-- Inputs -->
    <input type="text" id="inputMiddle" class="form-control form-custom"
           placeholder="Username"
           name="inputName">
    <input type="password" id="inputMiddle" class="form-control form-custom"
           placeholder="Password"
           name="inputPassword">
    <button class="btn btn-primary" id="button" type="submit" name="submit"
            value="Senden">Login
    </button>
    <br><br>
    <a href="index.php">Kein Konto? Hier als Gast einloggen.</a>

</form>
<!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
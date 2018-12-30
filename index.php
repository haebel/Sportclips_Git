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
<body id="bodyIndex" style="background-image:url(img/background.jpg)">
<form class="form-signin" name="formular" method="get" action="index.php">

    <h2>Sportclips Galerie</h2>
    <br><br>

    <b>SlowMotion-Wiedergabe</b>
    <input type="checkbox" onclick="myFunction()">
    <br><br>

    <?php
    error_reporting(0);

    session_start();

    $pid = $_SESSION['gast'];

    $inputVideo = $_GET['sportclips_file'];

    $dbdir = '../Sportclips_Git/db';

    /* Datenbankdatei ausserhalb htdocs öffnen bzw. erzeugen */
    $db = new SQLite3("$dbdir/sq3.db");

    /* Alles löschen (Wird in der fertigen Version nicht mehr benötigt) */
    //$db->exec("drop table TVideos");

    /* Tabelle mit Primärschlüssel erzeugen */
    $db->exec("CREATE TABLE IF NOT EXISTS TVideos (name, "
        . "id INTEGER PRIMARY KEY, video);");

    /* Datensätze eintragen */
    if ($inputVideo != "") {
        $sqlstr = "INSERT INTO TVideos (name, " . "id, video) VALUES ";
        $db->query($sqlstr . "('$inputVideo', NULL, '../Sportclips_Git/videos/$inputVideo')");
    }

    /* Verbindung zur Datenbankdatei wieder lösen */
    $db->close();

    /* Datenbankdatei öffnen bzw. erzeugen */
    $db = new SQLite3("$dbdir/sq3.db");

    $res = $db->query("SELECT * FROM TVideos");

    /* Abfrageergebnis ausgeben */
        while ($dsatz = $res->fetchArray(SQLITE3_ASSOC)) {
            echo $dsatz["id"]
                . ". " . $dsatz["name"]
                . " " . "<br>"
                . "<video id=\"sampleMovie\" width=\"960\" height=\"540\" preload controls>
               <source src='" . $dsatz["video"] . "'/>
               </video>" . "<br><br>";
        }

    /* Verbindung zur Datenbankdatei wieder lösen */
    $db->close();

    /* Upload einer Videodatei in das entsprechende Verzeichnis (Funktioniert nicht richtig) */
    if( $_FILES['sportclips_file']['name'] != "" )
    {
        $destFile = "../Sportclips_Git/videos/".$_FILES['sportclips_file']['name'];
        move_uploaded_file( $_FILES['sportclips_file']['tmp_name'], $destFile );
        echo $_FILES['sportclips_file']['name'];
    }
    else
    {
        //echo "No file specified!";
    }

    /* Upload-Funktion wird nur Schülern/Lehrpersonen angezeigt */
    if ($pid == FALSE)
    {
        echo '
        <br><br><br>
        <h4 class="form-signin-heading"><b>Neuen Clip hochladen</b></h4>

        Datei zum hochladen auswählen:
        <br>
        <form action="index.php" method="post" enctype="multipart/form-data">
            <input type="file" name="sportclips_file" id="sportclips_file">
            <input type="submit" name="sportclips_submit" value="Video hochladen">
        </form>
        <br><br>
        ';
    }
    ?>

</form>

<!-- Abmeldung -->
<br>
<form class="form-signin" name="formular" method="get" action="login.php">

    <button class="btn btn-primary" id="button" type="submit" name="submit"
            value="Senden">Abmelden
    </button>
    <br>

</form>

<!-- Slow Motion-Funktion -->
<script>
    function myFunction() {
        var x = document.getElementsByTagName('video');
        for( var i = 0; i < x.length; i++ ){
            if (x[i].playbackRate === 1.0) {
                x[i].playbackRate = 0.25;
            } else {
                x[i].playbackRate = 1.0;
            }
        }
    }
</script>

<!-- Binde alle kompilierten Plugins zusammen ein (wie hier unten) oder such dir einzelne Dateien nach Bedarf aus -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>
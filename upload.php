<?php
if( $_FILES['file']['name'] != "" )
{
    $destFile = "../Sportclips_Git/videos/".$_FILES['file']['name'];
    move_uploaded_file( $_FILES['file']['tmp_name'], $destFile );
    echo $_FILES['file']['name'];
}
else
{
    echo "No file specified!";
}
?>

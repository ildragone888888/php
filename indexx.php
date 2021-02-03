<?php
ini_set('error_reporting', E_ALL);
if(!isset($_POST['submit']))
{
echo "Быстрый конвертер jpeg в gif .. </br>
<form enctype='multipart/form-data' action='indexx.php' method='POST'>
<input type='hidden' name='MAX_FILE_SIZE' value='300000' />
<input name='userfile' type='file' />
<input type='submit' name='submit' value='Отправить файл' />
</form>";
}
if(isset($_POST['submit']))
{
if (exif_imagetype($_FILES['userfile']['tmp_name']) ==  IMAGETYPE_JPEG)
{
$rand = rand(0,100000);
$newgif = "$rand.gif";
$res = imagecreatefromjpeg($_FILES['userfile']['tmp_name']);
header("Content-type: image/gif");
imagegif($res);
}
}
?>

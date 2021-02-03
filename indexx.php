<?php 
if (exif_imagetype($_FILES['userfile']['tmp_name']) ==  IMAGETYPE_JPEG)
{
$rand = rand(0,100000);
$newgif = "$rand.gif";
$res = imagecreatefromjpeg($_FILES['userfile']['tmp_name']);
header("Content-type: image/gif");
imagegif($res);
}

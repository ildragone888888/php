<?php
if(!isset($_POST['submit']))
{
echo "
Быстрый конвертер jpeg в gif </br>
<form method='post' enctype='multipart/form-data'>
<input type='file' name='image' /></br>
<input type='submit' name='submit' value='ОК' />
</form>
";
}
if(isset($_POST['submit']))
{
if(exif_imagetype($_FILES['image']['tmp_name']) ==  IMAGETYPE_JPEG) 
{
$rand = rand(0,100000);
$newpng = "/app/$rand.gif";
imagegif(imagecreatefromjpeg($_FILES['image']['tmp_name']), $newpng);
}
$fset = file_get_contents("$newpng");
header("Content-type: image/gif");
echo $fset;
exit;
}

<?php
if(!isset($_POST['submit']))
{
echo "
Быстрый конвертер jpeg в gif>> </br>
<form method='post' enctype='multipart/form-data'>
<input type='file' name='image' /></br>
<input type='submit' name='submit' value='ОК' />
</form>
";
}
if(isset($_POST['submit']))
{
	echo "1";
if(exif_imagetype($_FILES['image']['tmp_name']) ==  "IMAGETYPE_JPEG") 
{
	echo "2";
$rand = rand(0,100000);
$newpng = "$rand.gif";
imagegif(imagecreatefromjpeg($_FILES['image']['tmp_name']), $newpng);
}
echo "
<a href='/$newpng'>$newpng</a>
";
}

<?php
echo "Быстрый конвертер jpeg в gif .. </br>
<form method='post' enctype='multipart/form-data'>
<input type='file' name='image' /></br>
<input type='submit' name='submit' value='ОК' />
</form>";
if(isset($_POST['submit']))
{
$filess = "".$_FILES['image']['tmp_name']."";
if (exif_imagetype($filess) ==  IMAGETYPE_JPEG)
{
$rand = rand(0,100000);
$newpng = "$rand.gif";
imagegif(imagecreatefromjpeg($filess), $newpng);
echo "<a href='/$newpng'>$newpng</a>";
}
}

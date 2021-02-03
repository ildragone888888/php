<?php
echo "<form enctype=multipart/form-data action=indexx.php method=POST>
    <input type=hidden name=MAX_FILE_SIZE value=1000000 />
    Отправить этот файл: <input name=userfile type=file />
    <input type=submit name=submit value=Отправить файл />
</form>";
if(isset($_POST['submit']))
{
$filess = "".$_FILES['userfile']['tmp_name']."";
if (exif_imagetype($filess) ==  IMAGETYPE_JPEG)
{
$rand = rand(0,100000);
$newpng = "$rand.gif";
imagegif(imagecreatefromjpeg($filess), $newpng);
echo "<a href='$newpng'>$newpng</a>";
}
}

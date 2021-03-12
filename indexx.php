<?php
if(!isset($_POST['submit']))
{
echo "Быстрый конвертер jpeg в gif ..1 </br>
<form enctype='multipart/form-data' action='indexx.php' method='POST'>
<input type='hidden' name='MAX_FILE_SIZE' value='300000' />
<input name='userfile' type='file' />
 <label for='pwd'>Password:</label>
<input type='password' id='pwd' name='pwd'> 
<input type='submit' name='submit' value='Отправить файл' />
</form>";
}
if(isset($_POST['submit']))
{
 echo "Error вы не авторизованы";
}

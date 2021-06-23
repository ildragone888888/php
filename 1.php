<?php
$headers =  getallheaders();
foreach($headers as $key=>$val){
$f = fopen("1.txt","a");
$ddd = "$key : $val</br>";
fwrite($f, $ddd); 
}
$f = fopen("1.txt","a");
$ddd = "--------------</br>";
fwrite($f, $ddd); 

<?php
$__content__ = '';
function prhe($headers) {
$flattened = array();
foreach ($headers as $key => $header) {
if (is_int($key)) {
$flattened[] = $header; 
} else {
if ($key == 'Connection')
{
$flattened['Connection'] = "".$key.": close";
}
else {		
$flattened[] = $key.': '.$header;
}
}
}
return implode("\r\n", $flattened);
}

function namef() {
$req = $_SERVER['REQUEST_URI'];
if (($req == '/') || ($req == '')) {
$nameff = 'zip.zip';
$namefr = 'application/zip';
}
else {
$nameff = str_replace('/', '', $req);
$namefr = substr($req, 1); 
$namefr = explode('.', $namefr);
$namefr = $namefr[1];
$tmp = file('mime.tmp');
foreach ($tmp as $key) {
$key = explode('||', $key); 
if ($key[0] == $namefr) {
$namefr = $key[1];
}
}
}
return array($nameff, $namefr);
}
$__password__ = base64_decode('MzQ1YQ==');
function echo_content($content) {
global $__password__;
list($nameff, $namefr) = namef();
header('Content-type: '.$namefr.'');
header('Content-Disposition: attachment; filename='.$nameff.'');
echo $content ^ str_repeat($__password__[0], strlen($content));
}
function decode_request($data) {
global $__password__;
list($headers_length) = array_values(unpack('n', substr($data, 0, 2)));
$header = array();
$header['method'] = $method;
$header['header'] = prhe($headers);
if (($body) && (($method != 'OPTIONS') || ($method != 'GET') || ($method != 'HEAD')))
{
$header['content'] = $body;
}
$header['follow_location'] = false;
$ht = parse_url($url);
$ht = $ht['scheme'];
$headersin = array($ht => $header);
$context  = stream_context_create($headersin);
$freq = file_get_contents($url, false, $context); 
$httpresh = $http_response_header;
foreach ($httpresh as &$value) {
$pos = strpos($value, ':');
if ($pos == false) {
$__content__ .= $value;
} 
else {
$key = join('-', array_map('ucfirst', explode('-', substr($value, 0, $pos))));
if ($key != 'Transfer-Encoding') {
$__content__ .= $key . substr($value, $pos);
}
}
$__content__ .= "\r\n";
}
 
$pos0 = strpos($__content__, '3');
if ($pos0 == 9)
{
$pos1 = strpos($__content__, 'HTTP/1.0 2');
if ($pos1 == '')
{
$pos1 = strpos($__content__, 'HTTP/1.1 2');
}
$__content__ = substr($__content__, 0, $pos1);
}

if ((($pos0 != 9) && ($ht == 'https')) && (($method != 'PUT') || ($method != 'HEAD')))
{
$__content__ .= "\r\n".$freq."";
}
if ($__content__) {
echo_content($__content__);
}
}
function get() {
$f = fopen ('1.tmp','rb');
$echo = fread($f,filesize('1.tmp'));
fclose($f);
list($nameff, $namefr) = namef();
header('Content-type: '.$namefr.'');
header('Content-Disposition: attachment; filename='.$nameff.'');
echo $echo;
}
function main() {
$shod = $_SERVER['REQUEST_METHOD'];
if (($shod == 'POST') || ($shod == 'PUT')) {
post(); } else {
get(); } }
main();

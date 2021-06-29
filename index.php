<?php
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
$__content__ = '';
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
function message_html($title, $banner, $detail) {
$error = "<title>${title}</title><body>${banner}</br>${detail}</body>";
return $error;
}
function decode_request($data) {
global $__password__;
list($headers_length) = array_values(unpack('n', substr($data, 0, 2)));
$headers_data = substr($data, 2, $headers_length);
$headers_data  = $headers_data ^ str_repeat($__password__, strlen($headers_data)); 
$headers_data = gzinflate($headers_data);
$lines = explode("\r\n", $headers_data); 
$request_line_items = explode(' ', array_shift($lines)); //
$method = $request_line_items[0];
$url = $request_line_items[1];
$headers = array();
$kwargs  = array();
$kwargs_prefix = 'X-URLFETCH-';
foreach ($lines as $line) {
if (!$line)
continue;
$pair = explode(':', $line, 2);
$key  = $pair[0];
$value = trim($pair[1]);
if (stripos($key, $kwargs_prefix) === 0) {
$kwargs[substr($key, strlen($kwargs_prefix))] = $value; //
} else if ($key) {
$key = join('-', array_map('ucfirst', explode('-', $key)));
$headers[$key] = $value;
}
}
$body = substr($data, 2+$headers_length);
if ($body) { 
$body  = $body ^ str_repeat($__password__, strlen($body));
$body = gzinflate($body);
}
$__password__ = $kwargs['password'];
return array($method, $url, $headers, $body);
}
function echo_content($content) {
global $__password__;
list($nameff, $namefr) = namef();
header('Content-type: '.$namefr.'');
header('Content-Disposition: attachment; filename='.$nameff.'');
echo $content ^ str_repeat($__password__[0], strlen($content));
}

function post() {
global $__content__;
list($method, $url, $headers, $body) = decode_request(file_get_contents('php://input'));
$header = array();
$header['method'] = $method;
$header['follow_location'] = false;
if (($body) && (($method != 'OPTIONS') || ($method != 'GET') || ($method != 'HEAD')))
{
$header['content'] = $body;
}
$header['header'] = prhe($headers);
$headersin = array('https' => $header);
$context  = stream_context_create($headersin);
$freq = file_get_contents($url, false, $context); 
$i = 1;
foreach ($http_response_header as $key) {
if ($i = 1)
{
$__content__ .= "".$key."\n";
}
else
{
$key1 = explode(':', $key);
$__content__ .= "".$key1[0]." : ".$key1[1]."\r\n";
}
$i++;
}
$__content__ .= "\r\n";
$pos2 = stripos($__content__, 'HTTP/1.1 2');
$__content__ = substr($__content__, $pos2);
if (($method != 'PUT') || ($method != 'HEAD'))
{
$__content__ .= "".$freq."";
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

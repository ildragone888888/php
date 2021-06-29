<?php
$__content__ = '';
$__password__ = base64_decode('MzQ1YQ==');
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

$header_array = array();
foreach ($headers as $key => $value) {
$header_array[] = join('-', array_map('ucfirst', explode('-', $key))).': '.$value;
}
$header = array();
$headerin['method'] = $method;
$headerout = '';
foreach ($header_array as $key => $value) {
$value = explode(":",$value);
$headerout .= "".$value[0].":".$value[1]."\r\n";
}
$headerin['header'] = $headerout;
if (($body) && (($method != 'OPTIONS') || ($method != 'GET') || ($method != 'HEAD'))) {
$headerin['content'] = $body;
}
$ht = parse_url($url);
$ht = $ht['scheme'];
$stcocr = array($ht => $headerin);
$context  = stream_context_create($stcocr);
$req = file_get_contents($url, false, $context); 
$httpresh = $http_response_header;
$idd = 1;
foreach ($httpresh as $value) {
$pos = strpos($value, ':');
if (($pos == false) && ($idd == 1)) {
$__content__ .= $value;
$__content__ .= "\r\n";
$idd++;
}
else if ($pos == false) {
break;
} 
else {
$key = join('-', array_map('ucfirst', explode('-', substr($value, 0, $pos))));
if ($key != 'Transfer-Encoding') {
$__content__ .= $key . substr($value, $pos);
$__content__ .= "\r\n";
}
}
}
$__content__ .= "\r\n";
$postemp = strpos($__content__, '3');	
if ($postemp != 9) {
	$__content__ .= $req;
}
else {
$__content__ .= "Location 3XX";
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

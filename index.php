<?php
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
$request_line_items = explode(" ", array_shift($lines));
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
$kwargs[strtolower(substr($key, strlen($kwargs_prefix)))] = $value;
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

function header_function($header) {
global $__content__;
$pos = strpos($header, ':');
if ($pos == false) {
$__content__ .= $header;
} 
else {
$key = join('-', array_map('ucfirst', explode('-', substr($header, 0, $pos))));
if ($key != 'Transfer-Encoding') {
$__content__ .= $key . substr($header, $pos);
}
}
return strlen($header);
}

function write_function($content,$nobody) {
global $__content__;
if ($__content__) {
$__content__ = "".$__content__."\r\n";
echo_content($__content__);
$__content__ = '';
}
if ($nobody == 0)
{
echo_content($content);
}
return strlen($content);
}

function post() {
list($method, $url, $headers, $body) = decode_request(file_get_contents('php://input'));
$method = strtoupper($method);
//if (isset($headers['Connection'])) { $headers['Connection'] = 'close'; }
$header_array = array();
foreach ($headers as $key => $value) {
$header_array[] = join('-', array_map('ucfirst', explode('-', $key))).': '.$value;
}
$headerin = array();
$nobody = 0;
switch (strtoupper($method)) { 
case 'HEAD':
$headerin['method'] = $method;
$nobody = 1;
break;
case 'GET':
break;
case 'POST':
$headerin['method'] = $method;
$headerin['content'] = $body;
break;
case 'DELETE':
case 'PATCH':
$headerin['method'] = $method;
$headerin['content'] = $body;
break;
case 'PUT':
$headerin['method'] = $method;
$headerin['content'] = $body; 
$nobody = 1;
break;
case 'OPTIONS':
$headerin['method'] = $method;
break;
default:
echo_content("HTTP/1.0 502\r\n\r\n" . message_html('502 Urlfetch Error', 'Method error ' . $method,  $url));
exit(-1);
}
$headerin['protocol_version'] = 1.1;
$headerin['ignore_errors'] = 1;
$headerin['follow_location'] = false;
$headerin['timeout'] = 50.5;
$headerin['header'] = $header_array;
$ht = parse_url($url); 
$ht = $ht['scheme'];
$stcocr = array('http' => $headerin);
$context = stream_context_create($stcocr);
//$strea = @file_get_contents($url, false, $context);
$strea1 = fopen($url, 'rb', false, $context);
$strea = fread($strea1, 1000000);
 
if ($strea === false) {
echo_content("HTTP/1.0 404\r\n\r\n" . message_html('404', $method,  $url));
exit(-1);
}
$ii = 0;
foreach ($http_response_header as $value) {
//if ($ii == 0) { $value = str_replace("HTTP/1.1","HTTP/2",$value); }
$value = "".$value."\r\n";
header_function($value);
$ii++;
}
$ii = 0;
write_function($strea, $nobody);
fclose($strea1);
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

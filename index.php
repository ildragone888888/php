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
$req = @file_get_contents($url, false, $context); 
$httpresh = $http_response_header;
$idd = 1;
foreach ($httpresh as $value) {
$pos = strpos($value, ':');
if (($pos == false) && ($idd == 1)) {
$__content__ .= $value;
$__content__ .= "\r\n";
$idd++;
}
else if ($pos == false)
{
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
$postemp = strpos($__content__, '301');	 
if ($postemp != 9) {
$__content__ .= $req;
}
else
{
$__content__ .= $req;
}

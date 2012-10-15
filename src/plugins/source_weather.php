<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

if ($question == '天气')
{
	$return['statistics']['source'] = 'weather';
	
	$sloc = new SaeLocation();
	$result = $sloc -> getIpToGeo(array('ip' => $_SERVER['REMOTE_ADDR']));
	$privince = $result['geos'][0]['province_name'];
	$city = $result['geos'][0]['city_name'];
	
	$return['text'] = "<strong>{$province}{$city}</strong>现在的天气是：";
	$return['weather'] = $city;
}
?>
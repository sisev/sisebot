<?php
if (isset($_REQUEST['i']))
{
	$fetcher = new SaeFetchurl();
	header('Content-Type: application/json;charset=utf-8');
	
	echo '[';
	
	$content = $fetcher -> fetch("http://www.weather.com.cn/data/sk/{$_REQUEST['i']}.html");
	echo $content;
	
	echo ',';
	
	$content = $fetcher -> fetch("http://m.weather.com.cn/data/{$_REQUEST['i']}.html");
	echo $content;
	
	echo ']';
}
?>
<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

if ($question == '时间')
{
	$return['statistics']['source'] = 'time';
	
	$return['text'] = '现在时间是：<strong>'.date('Y-m-d H:i:s').'</strong>';
}
?>
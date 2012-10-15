<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

if (FALSE !== strpos($question, '您好') || FALSE !== strpos($question, '你好'))
{
	$return['statistics']['source'] = 'greeting';
	
	$return['text'] = '您好，请问有什么可以帮到您呢？';
}
else if ($seg_words[0] == '呵呵')
{
	$return['statistics']['source'] = 'greeting';
	
	$return['text'] = '^_^';
}
?>
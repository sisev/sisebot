<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

if ($question == '关于' || $question == '华软机器人' || strtolower($question) == 'sisebot')
{
	array_push($return['statistics']['source'], 'about');
	
	$return['text'] = '<strong>SISEBOT v'.VERSION.'</strong><br />Prowered by SISE-DNA<br />开发：陈星宇';
	$return['text'] .= '<br /><br />我的工作离不开以下服务的支持，要感谢他们哟！<br /><ul>';
	$return['text'] .= '<li>Sina App Engine (服务器)</li>';
	$return['text'] .= '<li>新浪iAsk中文分词服务 (没他我听不懂话的)</li>';
	$return['text'] .= '<li>百度地图API 1.2 (度娘的地图哟)</li>';
	$return['text'] .= '</ul>';
}
?>
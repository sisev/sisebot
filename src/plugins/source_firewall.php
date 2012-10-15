<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

session_start();

if (!isset($_SESSION['repeat']))
{
	$_SESSION['repeat'] = 0;
}

if (isset($_SESSION['last']) && $_SESSION['last'] == $question)
{
	$return['statistics']['source'] = 'firewall';
	
	$FILTER_ENABLED = false;
	
	$_SESSION['repeat']++;
	
	if ($_SESSION['repeat'] <= 1)
	{
		$return['text'] = '嗯嗯，聊点别的吧';
	}
	else if ($_SESSION['repeat'] <= 2)
	{
		$return['text'] = '亲，我知道了啦，不用重复啦';
	}
	else if ($_SESSION['repeat'] <= 4)
	{
		$return['text'] = '亲啊，人家都说知道了啦';
	}
	else if ($_SESSION['repeat'] <= 10)
	{
		$return['text'] = '矮油，别老重复同一句话嘛';
	}
	else
	{
		$return['text'] = '你妹有完没完啊老重复同样的东西，吼……';
	}
}
else
{
	$_SESSION['repeat'] = 0;
	$_SESSION['last'] = $question;
}
?>
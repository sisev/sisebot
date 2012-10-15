<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

if (FALSE !== $pos = array_search(SaeSegment::POSTAG_ID_N_RZ, $seg_types))
{
	array_push($return['statistics']['filters'], 'person');
	
	if (isset($return['text']))
	{
		$return['text'] .= "<br />这是谁的名字吗？";
	}
	else
	{
		$return['text'] = "<strong>{$seg_words[$pos]}</strong>是谁的名字吗？人家不认识TA了啦……&gt; &lt;<br />";
		$return['text'] .= "<ul>";
		$return['text'] .= "<li><a href=\"http://zh.wikipedia.org/w/index.php?title=Special%3A%E6%90%9C%E7%B4%A2&search=".urlencode($seg_words[$pos])."\" target=\"_blank\">上维基找一下</a></li>";
		$return['text'] .= "<li><a href=\"https://www.google.com/search?q=".urlencode($seg_words[$pos])."\" target=\"_blank\">上谷歌找一下</a></li>";
		$return['text'] .= "</ul>";
	}
}
?>
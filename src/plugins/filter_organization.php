<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

if (FALSE !== $pos = array_search(SaeSegment::POSTAG_ID_N_TZ, $seg_types))
{
	array_push($return['statistics']['filters'], 'organization');
	
	if (isset($return['text']))
	{
		$return['text'] .= "<br />你要找<strong>{$seg_words[$pos]}</strong>在哪里吗？我看看……";
	}
	else
	{
		$return['text'] = "你要找<strong>{$seg_words[$pos]}</strong>在哪里吗？我看看……";
	}
	$sloc = new SaeLocation();
	$result = $sloc -> getIpToGeo(array('ip' => $_SERVER['REMOTE_ADDR']));
	$return['geo'] = array(
		'long' => $result['geos'][0]['longitude'],
		'lat' => $result['geos'][0]['latitude'],
		'keyword' => $seg_words[$pos]
	);
}
?>
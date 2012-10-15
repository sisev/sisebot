<?php
if (!defined('IN_SISEBOT'))
{
	header('HTTP/1.1 404 Not Found');
	die;
}

if (FALSE !== $pos = array_search(SaeSegment::POSTAG_ID_NS_Z, $seg_types))
{
	array_push($return['statistics']['filters'], 'location');
	
	if (isset($return['text']))
	{
		$return['text'] .= "<br /><strong>{$seg_words[$pos]}</strong>是某个地方的名字？我找找看……";
	}
	else
	{
		$return['text'] = "<strong>{$seg_words[$pos]}</strong>是某个地方的名字？我找找看……";
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
<?php
if (!defined('IN_SISEBOT')) {
	header('HTTP/1.1 404 Not Found');
	die;
}

$answers = array(
	"“{$question}”是什么？",
	"然后呢……",
	"哦",
	"……"
);
$seed = floor(rand(0, count($answers) - 1));
$return['text'] = $answers[$seed];

if ($seed == 0) {
	$_SESSION['question'] = $question;
}
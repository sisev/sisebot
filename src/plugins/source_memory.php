<?php
if (!defined('IN_SISEBOT')) {
	header('HTTP/1.1 404 Not Found');
	die;
}

$db = new mysqli(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS, SAE_MYSQL_DB);

$ignore = array(
	//SaeSegment::POSTAG_ID_W,	// 标点符号
	SaeSegment::POSTAG_ID_W_D,	// 顿号
	SaeSegment::POSTAG_ID_W_H,	// 中缀型符号
	SaeSegment::POSTAG_ID_W_L,	// 搭配型标点左部
	SaeSegment::POSTAG_ID_W_R,	// 搭配型标点右部
	SaeSegment::POSTAG_ID_W_S,	// 分句尾标点
	SaeSegment::POSTAG_ID_W_SP	// 句号
);

$keywords = array();
foreach ($seg_words as $s) {
	array_push($keywords, "'".$db -> real_escape_string($s)."'");
}

$sql = "SELECT `answer` FROM `answers` WHERE `id` = (SELECT `answer_id` FROM `keywords` WHERE `keyword` IN (".implode(',', $keywords).") AND `type` NOT IN (".implode(',', $ignore).") GROUP BY `answer_id` ORDER BY COUNT(*) DESC, `id` DESC LIMIT 1) LIMIT 1;";
$result = $db -> query($sql);

if ($db -> affected_rows > 0) {
	$return['statistics']['source'] = 'memory';
	
	$row = $result -> fetch_assoc();
	$return['text'] = htmlspecialchars($row['answer']);
}

$db -> close();

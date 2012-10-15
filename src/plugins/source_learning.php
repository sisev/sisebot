<?php
if (!defined('IN_SISEBOT')) {
	header('HTTP/1.1 404 Not Found');
	die;
}

if (!empty($_SESSION['question'])) {
	$return['statistics']['source'] = 'learning';
	
	$answer = $question;
	$question = $_SESSION['question'];
	
	if (empty($question) || empty($answer)) {
		$return['text'] = '不懂……';
	} else {
		$db = new mysqli(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS, SAE_MYSQL_DB);
		$sql = "INSERT INTO `answers` (`answer`) VALUES (?);";
		$stmt = $db -> prepare($sql);
		$stmt -> bind_param("s", $answer);
		$stmt -> execute();
		
		$answer_id = $stmt -> insert_id;
		
		$sql = "INSERT INTO `keywords` (`keyword`, `type`, `answer_id`) VALUES (?, ?, ?);";
		$stmt = $db -> prepare($sql);
		$stmt -> bind_param("sii", $keyword, $type, $answer_id);
		
		$segment = $seg -> segment($question, 1);
		
		if ($segment[0]['word'] != $question) {
			$keyword = $question;
			$type = 1;
			$stmt -> execute();
		}
		
		foreach ($segment as $s) {
			$keyword = $s['word'];
			$type = $s['word_tag'];
			$stmt -> execute();
		}
		
		$return['text'] = '多谢指教！^_^';
		
		unset($_SESSION['question']);
		
		$stmt -> close();
		$db -> close();
	}
}

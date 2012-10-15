<?php
define('IN_SISEBOT', 1);
define('VERSION', '0.2.5');
header('Content-Type: application/json');

if (!empty($_REQUEST['s'])) {
	$question = $_REQUEST['s'];
	$return = array();
	
	/* 准备统计数据 */
	$return['statistics'] = array();
	$return['statistics']['source'] = 'NO_DATA';
	$return['statistics']['filters'] = array();
	
	/* 准备分词服务 */
	$seg = new SaeSegment();
	$segment = $seg -> segment($question, 1);
	$seg_words = array();
	$seg_types = array();
	foreach ($segment as $i => $s) {
		$seg_words[$i] = $s['word'];
		$seg_types[$i] = $s['word_tag'];
	}
	
	/* 是否单词指令 */
	$single = $seg_words[0] == $question;
	
	/* 加载处理插件配置 */
	include './plugins.php';
	
	/* 是否启用过滤器，可能会被数据源修改 */
	$FILTER_ENABLED = TRUE;
	
	/* 遍历数据源并在得到数据后跳出 */
	foreach ($PLUGINS_SOURCE as $name) {
		include "./plugins/source_{$name}.php";
		if (isset($return['text'])) break;
	}
	
	/* 若启用过滤器，逐一调用 */
	if ($FILTER_ENABLED) {
		foreach ($PLUGINS_FILTER as $name) {
			include "./plugins/filter_{$name}.php";
		}
	}
	
	/* 输出 */
	echo json_encode($return);
}
?>
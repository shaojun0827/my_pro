<?php
//设定头文件
header("content-type:text/html;charset=utf-8");
function show_log($msg){
	echo '<pre>';
	var_dump($msg);
	echo '</pre>';
}
// 检测PHP版本 必须PHP5.5以上哦
if(version_compare(PHP_VERSION,'5.5.0','<'))  die('require PHP > 5.5.0 ! PHP版本必须PHP5.5以上！');

define('ROOT_PATH', __DIR__ . '/');
// 开启调试模式
// define('APP_DEBUG',True);

echo microtime(true);
echo '<br>';

$svr = explode('.', $_SERVER['HTTP_HOST']);
if (count($svr) == 2) {
	define('HTML_PATH', ROOT_PATH . "static/{$svr[1]}/{$svr[0]}/www");
} else {
	define('HTML_PATH', ROOT_PATH . "static/{$svr[2]}/{$svr[1]}/{$svr[0]}");
}


require '../ThinkPHP/ThinkPHP.php';
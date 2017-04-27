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

// define('ROOT_PATH', '/home/product/');
define('ROOT_PATH', __DIR__ . '/');
// 开启调试模式
// define('APP_DEBUG',True);

// echo microtime(true);
// echo '<br>';



$svr = explode('.', $_SERVER['SERVER_NAME']);
var_dump($_SERVER);
if (count($svr) == 2) {
	define('HTML_PATH', "/home/product/{$svr[1]}/{$svr[0]}/www");
} else {
	define('HTML_PATH', "/home/product/{$svr[2]}/{$svr[1]}/{$svr[0]}");
}
$html_path = '/home/product/'.HTML_PATH;
$file_path = $html_path.$_SERVER['REQUEST_URI'];
if (!file_exists($file_path)) {
    if (!file_exists($html_path)) {
        $server_name = $_SERVER['SERVER_NAME'];
        // system("touch /usr/local/openresty/nginx/conf/sites-enabled/{$server_name}.conf", $result);
        // system("cat > /usr/local/openresty/nginx/conf/sites-enabled/{$server_name}.conf << EOF
        system("touch /etc/nginx/sites-enabled/{$server_name}.conf", $result);
        system("cat > /etc/nginx/sites-enabled/{$server_name}.conf << EOF
server {
    server_name $server_name;
    listen 80;
    root /home/product;
    location / {
        root index.html;
    }
}
EOF");
        // system ("/usr/local/openresty/nginx/sbin/nginx -s reload");
        system("nginx -s reload");
    }
    require '../ThinkPHP/ThinkPHP.php';
}



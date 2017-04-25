<?php
if ($_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.html') {
    $control = 'Index';
} elseif (substr($_SERVER['REQUEST_URI'], -5) == '.html') {
    $control = 'Content';
} else {
    $control = 'List';
}

return array(
    // 路由设置
    'URL_ROUTER_ON'         => true,
    'URL_ROUTE_RULES'       => array(
        '/([A-Za-z0-9\/]+)/'        => "index.php/Home6uF2rSJDe/{$control}/index?path=:1",
    ),
);
<?php

return array(
    'DEFAULT_MODULE'        => 'Home6uF2rSJDe',                             // 默认模块
    // 'DEFAULT_THEME'        => 'default',
    'VIEW_PATH'             => ROOT_PATH . 'Template/',
    // 'TMPL_FILE_DEPR'        => '_',
    
    // 重新定义模板常量
    'TMPL_PARSE_STRING'     => array(
        '__PUBLIC__'        => '/style'

    ),


    'TUIGUANG_URL_PRECENT'  => 0,


    'HTML_CACHE_ON'         => true,                                        // 开启静态缓存
    'HTML_CACHE_TIME'       => 0,                                           // 全局静态缓存有效期（秒）
    'HTML_FILE_SUFFIX'      => '.html',                                     // 默认静态文件后缀

    'LOAD_EXT_CONFIG'       => 'randnum,route,file',                        // 加载额外配置
);

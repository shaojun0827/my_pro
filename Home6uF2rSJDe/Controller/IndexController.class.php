<?php
namespace Home6uF2rSJDe\Controller;
use Home6uF2rSJDe\Controller\HomeController;
class IndexController extends HomeController {
    public function index(){
        $noSuffix_path = HTML_PATH . "/index";
        $complete_path = $noSuffix_path . '.html';
        if (!file_exists($complete_path)) {
            $this->assign(
                array(
                    'content'     => '',
                    'title'       => '',
                    'keywords'    => '',
                    'description' => '',
                )
            );

            $this->buildHtml(basename($noSuffix_path), dirname($complete_path) . '/', 'index', 'utf8');
            $str = file_get_contents($complete_path);
            $str = parseTemplete($str);
            file_put_contents($complete_path, $str);
        }
        $this->show($complete_path);
    }
}
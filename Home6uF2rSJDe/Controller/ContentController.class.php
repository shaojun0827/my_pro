<?php
namespace Home6uF2rSJDe\Controller;
use Home6uF2rSJDe\Controller\HomeController;
class ContentController extends HomeController {
    public function index(){
        $path          = isset($_GET['path']) ? $_GET['path'] : '';
        $noSuffix_path = HTML_PATH . "/{$path}";
        $complete_path = $noSuffix_path . '.html';

        if (!file_exists($complete_path)) {
            $this->assign(
                array(
                    'content'     => $this->getContent(),
                    'title'       => getTitle(),
                    'keywords'    => '',
                    'description' => '',
                )
            );

            $this->buildHtml(basename($noSuffix_path), dirname($complete_path) . '/', 'content1', 'utf8');
            $str = file_get_contents($complete_path);
            $str = parseTemplete($str);
            file_put_contents($complete_path, $str);
        }
        $this->show($complete_path);
    }

    private function getContent(){
        $str = file_get_contents(C('FILE_PATH') . C('TEMPLATE_PATH') . C('ARTICLE_FILE_PATH') . '1.txt');
        return $str;
    }

}
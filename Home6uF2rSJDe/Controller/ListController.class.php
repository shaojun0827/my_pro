<?php
namespace Home6uF2rSJDe\Controller;
use Home6uF2rSJDe\Controller\HomeController;
class ListController extends HomeController {
    public function index(){
        $path = isset($_GET['path']) ? $_GET['path'] : '';
        $noSuffix_path = HTML_PATH . "/{$path}";
        if (substr($noSuffix_path, -1) != '/') {
            $noSuffix_path .= '/';
        }
        $complete_path = $noSuffix_path . 'index.html';
        if (file_exists($complete_path)) {
            $this->show($complete_path);
        } else {
             $this->assign(
                array(
                    'title'       => $this->getTDKTemp('title'),
                    'keywords'    => $this->getTDKTemp('keywords'),
                    'description' => $this->getTDKTemp('description'),
                    'totalPage'   => $this->getTotalPage(),
                )
            );

            $this->buildHtml('index', dirname($complete_path) . '/', 'index', 'utf8');
            $str = file_get_contents($complete_path);
            $str = parseTemplete($str);
            file_put_contents($complete_path, $str);
            $this->show($complete_path);
        }
    }

    private function getTotalPage(){
        return $this->randNum(2, 10);
    }

    public function getTDKTemp($type = 'title'){
        $path  = C('FILE_PATH').C('TEMPLATE_PATH');
        switch ($type) {
            case 'description':
                $path .= C('DESCRIPTION_FILE_PATH');
                break;
            case 'keywords':
                $path .= C('KEYWORDS_FILE_PATH');
                break;
            case 'title':
            default:
                $path .= C('TITLE_FILE_PATH');
                break;
        }
        $files = scandir($path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key       = array_rand($files);
        $file_path = $path . $files[$key];
        $tmp_arr   = file($file_path);
        shuffle($tmp_arr);
        $tmp_key   = array_rand($tmp_arr);
        return trim($tmp_arr[$tmp_key]);
    }

    public function getDomain(){
        getRandAuthor();
    }
}
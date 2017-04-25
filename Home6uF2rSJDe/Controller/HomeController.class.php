<?php
namespace Home6uF2rSJDe\Controller;
use Think\Controller;

class HomeController extends Controller {
    public function randWord($left, $right){
        $left  = $left < 1 ? 1 : $left;
        $right = $right < $left ? $left : $right;
        $str   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789';
        $rand  = mt_rand($left, $right);
        $res   = '';
        for ($i=0; $i < $rand; $i++) { 
            $tmp = mt_rand(0, 61);
            $res .= $str{$tmp};
        }
        return $res;
    }

    public function randNum($left, $right){
        $left  = $left < 1 ? 1 : $left;
        $right = $right < $left ? $left : $right;
        $rand  = mt_rand($left, $right);
        return $rand;
    }

    public function _after_index(){
        // echo microtime(true);
        // echo '<br>';
        die();
    }
}
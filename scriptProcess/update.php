<?php

set_time_limit(0);

$ush = new UpdateStaticHtml();

$ush->ergodic_file('f:\groupsite\static\\');
class UpdateStaticHtml
{
    public function get_file_path(){
        $path = dirname(__DIR__).'/txtzhDSYvb6/words/';
        return $path;
    }
    public function get_host($url){
        $arr = parse_url($url);
        return $arr['host'];
    }
    public function parse_old_url($file_path){
        $file = file_get_contents($file_path);
        // preg_match_all("/<a[^<>]+time *\= *[\"']?([0-9]+)[\"'] *href *\= *[\"']?(http\:\/\/[^ '\"]+)/i", $file, $match);
        preg_match_all("/<a[^<>]+time *\= *[\"']?([0-9]+)[\"'] *href *\= *[\"']?(http\:\/\/[^ '\"]+)[^<>]+[>]([^<>]+)<\/a>/i", $file, $match);
        $max_time = max($match[1]);
        $min_time = min($match[1]);
        $now_time = time();
        // 若有1天内的时间，则不需要更新该文件
        if ($now_time - $max_time <= 60*60*24*1) {
            echo "file update less than one day\n";
            unset($file);
            unset($match);
            return false;
        }
        foreach ($match[1] as $key => $val) {
            // 生成的时间为1天以内，则无需改变
            if ($now_time - intval($val) <= 60*60*24*2) {
                unset($match[1][$key]);
            }
        }
        $time_count = count($match[1]);
        if ($time_count == 0) {
            echo 'can\'t update!';
            return false;
        }
        // 执行替换链接
        $key_arr = array();
        for ($i=0; $i < 1; $i++) {
            $key  = mt_rand(0, $time_count-1);
            if (in_array($key, $key_arr)) {
                $i--;
                continue;
            }
            $url  = 'http://'.$this->get_host($match[2][$key]).$this->get_url();
            $file = str_replace($match[0][$key], '<a time="'.$now_time.'" href="'.$url.'">'.$this->get_words().'</a>', $file);
        }

        file_put_contents($file_path, $file);
        unset($file);
        unset($match);
    }
    public function rand_word($left, $right){
        $left  = $left < 1 ? 1 : $left;
        $right = $right < $left ? $left : $right;
        $str   = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789';
        $rand  = mt_rand($left, $right);
        $res   = '';
        for ($i=0; $i < $rand; $i++) {
            $_rand = mt_rand(0, 61);
            $res  .= $str{$_rand};
        }
        return $res;
    }
    public function get_url(){
        // 获取链接随机层数
        $num = mt_rand(1, 3);
        $url = '';
        for ($i=0; $i < $num; $i++) { 
            $url .= '/' . $this->rand_word(4, 8);
        }
        $rand = mt_rand(1, 100);
        $url  = $rand > 60 ? $url : $url . '.html';
        return $url;
    }
    public function get_words(){
        $words_path = $this->get_file_path();
        $files      = scandir($words_path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key      = mt_rand(0, count($files)-1);
        $word_arr = file($words_path . $files[$key]);
        unset($files);
        $word_key1 = mt_rand(0, count($word_arr)-1);
        $word_key2 = mt_rand(0, count($word_arr)-1);
        $words     = trim($word_arr[$word_key1]) . trim($word_arr[$word_key2]);
        unset($word_arr);
        return $words;
    }

    /**
     * 遍历所有文件
     */
    public function ergodic_file($path){
        $files = scandir($path);
        unset($files[0], $files[1]);
        foreach ($files as $key => $val) {
            if (substr($val, -5) == '.html') {
                // $this->parse_old_url($path.'/'.$val);
            } elseif (substr($val, -4) == '.txt') {
            } else {
                echo $val."--file\n";
                // $this->ergodic_file($path.'/'.$val);
            }
            unset($files[$key]);
        }
    }
}
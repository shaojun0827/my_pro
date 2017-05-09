<?php
    /**
     * 随机获取数字和字母组合
     */
    function randWord($left, $right){
        $left   = $left < 1 ? 1 : $left;
        $right  = $right < $left ? $left : $right;
        $str    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIGKLMNOPQRSTUVWXYZ0123456789';
        $strLen = strlen($str)-1;
        $rand   = mt_rand($left, $right);
        $res    = '';
        for ($i = 0; $i < $rand; $i++) {
            $_rand = mt_rand(0, $strLen);
            $res  .= $str{$_rand};
        }
        return $res;
    }

    /**
     * 随机获取一定范围内数字
     */
    function randNum($left, $right){
        $left  = $left < 1 ? 1 : $left;
        $right = $right < $left ? $left : $right;
        $rand  = mt_rand($left, $right);
        return $rand;
    }

    /**
     * 随机获取url链接
     */
	function getUrl(){
        // 获取链接随机层数
        $num = randNum(C('URL_RAND_FLOOR_NUM_LEAST'), C('URL_RAND_FLOOR_NUM_MOST'));
        $url = '';
        for ($i=0; $i < $num; $i++) {
            $url .= '/' . randWord(C('URL_FLOOR_CHAR_NUM_LEAST'), C('URL_FLOOR_CHAR_NUM_MOST'));
        }
        $precent  = C('URL_HAS_SUFFIX_PRECENT');
        if ($precent >= 1 && $precent <= 0) {
            $precent = 0.5;
        }
        $numArr   = explode('.', $precent);
        $totalNum = pow(10, strlen($numArr[1]));
        $rand     = randNum(1, $totalNum);
        $url      = $rand > intval($numArr[0]) ? $url : $url . '.html';
        return $url;
    }

    /**
     * 随机获取标题
     */
    function getTitle(){
        $wordsArr = C('WORDS_FILE');
        $wordsKey = array_rand($wordsArr);
        $wordsTxt = C('FILE_PATH') . C('WORDS_FILE_PATH') . $wordsArr[$wordsKey] . '.txt';
        while (true) {
            if (!file_exists($wordsTxt)) {
                break;
            }
            $file = fopen($wordsTxt, 'r');
            if (!$file) {
                break;
            }
            $total_num = intval(fgets($file));
            $min       = randNum(1, $total_num);
            $tmp       = randNum(1, $total_num);
            $max       = $min > $tmp ? $min : $tmp;
            $min       = $min > $tmp ? $tmp : $min;
            $count     = 1;
            $words     = '';
            while (!feof($file)) {
                if ($count == $min) {
                    $words .= trim(fgets($file));
                } elseif ($count == $max) {
                    $words .= trim(fgets($file));
                } elseif ($count > $max) {
                    if ($min == $max) {
                        $words .= $words;
                    }
                    break;
                } else {
                    fgets($file);
                }
                $count++;
            }
            return $words;
        }
        $words = '';
        $word  = C('SOME_WORD');
        $total = mb_strlen($word);
        for ($i=0; $i < 4; $i++) {
            $words .= mb_substr($word, randNum(0, $total - 1), 3);
        }
        return $words;
    }

    /**
     * 获取词语库中的随机词语
     */
    function getWords($num = 1){
        $contentArr = C('WORDS_FILE');
        $contentKey = array_rand($contentArr);
        $path       = C('FILE_PATH') . C('WORDS_FILE_PATH') . $contentArr[$contentKey] . '.txt';

        while (true) {
            if (!file_exists($path)) {
                break;
            }
            $file = fopen($path, 'r');
            if (!$file) {
                break;
            }

            $total_num = intval(fgets($file));
            $numArr    = array();
            for ($i=0; $i < $num; $i++) { 
                $numArr[] = randNum(1, $total_num);
            }
            sort($numArr);
            $count     = 1;
            $content   = '';
            while (!feof($file)) {
                if ($count == $numArr[0]) {
                    $content .= trim(fgets($file));
                    unset($numArr[0]);
                    if (!$numArr) break;
                    sort($numArr);
                } else {
                    fgets($file);
                }
                $count++;
            }
            return $content;
        }
    }

    /**
     * 获取随机域名
     */
    function getRandDomain(){
        $domain_path = C('FILE_PATH') . C('DOMAIN_FILE_PATH');
        $files       = scandir($domain_path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key = array_rand($files);
        $file_path = $domain_path . $files[$key];
        if (!file_exists($file_path)) {
            return C('DEFAULT_DOMAIN');
        }
        $file_arr  = file($file_path);
        shuffle($file_arr);
        $domain_key = array_rand($file_arr);
        return trim($file_arr[$domain_key]);
    }

    /**
     * 获取随机图片
     */
    function getRandImages(){
        $images_file_path = C('IMAGE_FILE_PATH');
        $files = scandir(ROOT_PATH . $images_file_path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key = mt_rand(0, count($files)-1);
        $img = $files[$key];
        return '/' . $images_file_path . $img;
    }

    /**
     * 获取完整链接/需要添加的自定义链接
     */
    function final_url(){
        $precent = C('TUIGUANG_URL_PRECENT');
        if (intval($precent) == 0 || $precent < 0 || $precent > 1) {
            return 'http://'.getRandDomain().getUrl();
        }
        $num     = explode('.', $precent);
        $y       = strlen($num[1]);
        $power   = pow(10, $y);
        $rand    = mt_rand(1, $power);
        $precent = intval($precent * $power);
        if ($rand <= $precent) {
            $path  = C('FILE_PATH').C('URL_FILE_PATH');
            $files = scandir($path);
            unset($files[0], $files[1]);
            shuffle($files);
            $key      = mt_rand(0, count($files)-1);
            $url_path = $path . $files[$key];
            $url_arr  = file($url_path);
            shuffle($url_file);
            $url_key  = mt_rand(0, count($url_arr)-1);
            return trim($url_arr[$url_key]);
        } else {
            return 'http://'.getRandDomain().getUrl();
        }
    }

    /**
     * 获取文件总行数
     */
    function getFileTotalLine($path){
        $total_line = 0;
        $fp = fopen($path, 'r');
        if($fp){
            /* 获取文件的一行内容，注意：需要php5才支持该函数; */
            while(stream_get_line($fp, 4096, "\r\n")){
                $total_line++;
            }
        }
        fclose($fp);
        return $total_line;
    }

    /**
     * 替换模板文件
     */
    function parseTemplete($file){
        $file = parse_content($file);
        $file = parse_a_tag($file);
        $file = parse_time($file);
        $file = parse_img_tag($file);
        $file = parse_juzi($file);
        $file = parse_duanyu($file);
        $file = parse_danci($file);
        $file = parse_major_keywords($file);
        $file = parse_rand_keywords($file);
        $file = parse_domain($file);
        $file = parse_rand_url($file);
        $file = parse_rand_num($file);
        $file = parse_sitemap($file);
        $file = parse_friendlink($file);
        $file = parse_author($file);
        return $file;
    }

    /**
     * 解析A标签
     * 格式为<a:>或<a:资讯>或<a:dfasdfasd.com#资讯>第1个为url地址，不需加http。第2个参数为A标签的名称，不写则随机。
     */
    function parse_a_tag($file){
        $partten = '/<a\:(.*?)>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        $time  = time();
        for ($i=0; $i < $count; $i++) {
            $tmp = '';
            if (!empty($match[1][$i])) {
                $tmp  = explode('#', $match[1][$i]);
            }
            if ($tmp && $tmp[0]) {
                $aUrl = 'http://' . $tmp[0];
            } else {
                $aUrl = final_url();
            }
            if ($tmp && $tmp[1]) {
                $name = $tmp[1];
            } else {
                $name = getWords(2);
            }
            $_val = $match[0][$i];
            $_val = str_replace('/', '\/', $_val);
            $name = str_replace('{', '<', $name);
            $name = str_replace('}', '>', $name);
            $file = preg_replace("/{$_val}/", '<a time="'.$time.'" href="'.$aUrl.'">'.$name.'</a>', $file, 1);
        }
        return $file;
    }

    /**
     * 解析IMG标签
     * 格式为<img:>或<img:资讯>或<img:aaa.bbb.com#资讯>第一个为img地址，不需加http。第二个参数为img标签的alt，不写则随机。
     */
    function parse_img_tag($file){
        $partten = '/<img\:(.*?)>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        $time = time();

        for ($i=0; $i < $count; $i++) {
            $tmp = '';
            if (!empty($match[1][$i])) {
                $tmp   = explode('#', $match[1][$i]);
            }
            if ($tmp && $tmp[0]) {
                $url = 'http://' . $tmp[0];
            } else {
                $url = getRandImages();
            }
            if ($tmp && $tmp[1]) {
                $alt = $tmp[1];
            } else {
                $alt = getWords(2);
            }
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", '<img src="'.$url.'" alt="'.$alt.'">', $file, 1);
        }
        return $file;
    }

    /**
     * 替换自定义句子标签
     * 格式为<内容模板>
     */
    function parse_content($file){
        $partten = '/<内容模板>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $content_tmp_path = C('FILE_PATH').C('TEMPLATE_PATH').C('ARTICLE_FILE_PATH');
            $files            = scandir($content_tmp_path);
            unset($files[0], $files[1]);
            shuffle($files);
            $key     = mt_rand(0, count($files)-1);
            $content = file_get_contents($content_tmp_path.$files[$key]);
            $file    = preg_replace("/{$_val}/", trim($content), $file, 1);
        }
        return $file;
    }

    /**
     * 替换自定义句子标签
     * 格式为<句子>
     */
    function parse_juzi($file){
        $partten = '/<句子>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", getWords(3), $file, 1);
        }
        return $file;
    }

    /**
     * 替换自定义短语标签
     * 格式为<短语>
     */
    function parse_duanyu($file){
        $partten = '/<短语>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", getWords(2), $file, 1);
        }
        return $file;
    }

    /**
     * 替换自定义单词标签
     * 格式为<单词>
     */
    function parse_danci($file){
        $partten = '/<单词>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", getWords(1), $file, 1);
        }
        return $file;
    }

    /**
     * 替换自定义单词标签
     * 格式为<时间>
     */
    function parse_time($file){
        $partten = '/<时间>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", date('Y-m-d H:i:s', time()), $file, 1);
        }
        return $file;
    }

    /**
     * 替换主关键词标签
     * 格式为<主关键词>
     */
    function parse_major_keywords($file){
        $partten = '/<主关键词>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        $keywords_file_path = HTML_PATH . '/keywords.txt';
        if (!file_exists($keywords_file_path)) {
            build_keywords_file();
        }
        $keywordsArr = file($keywords_file_path);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i]; 
            $file = preg_replace("/{$_val}/", trim($keywordsArr[0]), $file, 1);
        }
        return $file;
    }

    /**
     * 替换随机关键词标签
     * 格式为<随机关键词>
     */
    function parse_rand_keywords($file){
        $partten = '/<随机关键词>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        $keywords_file_path = HTML_PATH . '/keywords.txt';
        if (!file_exists($keywords_file_path)) {
            build_keywords_file();
        }
        $keywordsArr = file($keywords_file_path);
        unset($keywordsArr[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $key  = mt_rand(0, count($keywordsArr)-1);
            $file = preg_replace("/{$_val}/", trim($keywordsArr[$key]), $file, 1);
        }
        return $file;
    }

    /**
     * 替换域名标签
     * 格式为<域名>
     */
    function parse_domain($file){
        $partten = '/<域名>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", getRandDomain(), $file, 1);
        }
        return $file;
    }

    /**
     * 替换域名标签
     * 格式为<随机URL链接>
     */
    function parse_rand_url($file){
        $partten = '/<随机URL链接>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", final_url(), $file, 1);
        }
        return $file;
    }

    /**
     * 替换域名标签
     * 格式为<随机数>
     */
    function parse_rand_num($file){
        $partten = '/<随机数>/i';
        preg_match_all($partten, $file, $match);
        $count = count($match[0]);
        for ($i=0; $i < $count; $i++) {
            $_val = $match[0][$i];
            $file = preg_replace("/{$_val}/", randNum(1,1000), $file, 1);
        }
        return $file;
    }

    /**
     * 替换作者标签
     * 格式为<作者>
     */
    function parse_author($file){
        $partten     = '/<作者>/i';
        preg_match_all($partten, $file, $match);
        $count       = count($match[0]);
        $author_path = C('FILE_PATH') . C('AUTHOR_FILE_PATH');
        $files       = scandir($author_path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key        = mt_rand(0, count($files)-1);
        $file_path  = $author_path . $files[$key];
        if (!file_exists($file_path)) {
            $author = C('DEFAULT_AUTHOR');
        } else {
            $authors    = file($file_path);
            shuffle($authors);
            $author_key =  mt_rand(0, count($authors)-1);
            $author     = $authors[$author_key];
        }
        $file = preg_replace($partten, trim($author), $file);
        return $file;
    }

    /**
     * 替换作者标签
     * 格式为<网站地图>
     */
    function parse_sitemap($file){
        $partten   = '/<网站地图>/i';
        preg_match_all($partten, $file, $match);
        $count     = count($match[0]);
        $map_path  = C('FILE_PATH') . C('SITEMAP_FILE_PATH');
        $files     = scandir($map_path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key       = mt_rand(0, count($files)-1);
        $file_path = $map_path . $files[$key];
        $map       = file_get_contents($file_path);
        $file = preg_replace($partten, trim($map), $file);
        return $file;
    }

    /**
     * 替换作者标签
     * 格式为<友情链接>
     */
    function parse_friendlink($file){
        $partten   = '/<友情链接>/i';
        preg_match_all($partten, $file, $match);
        $count     = count($match[0]);
        $link_path = C('FILE_PATH') . C('FRIENDLINK_FILE_PATH');
        $files     = scandir($link_path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key       = mt_rand(0, count($files)-1);
        $file_path = $link_path . $files[$key];
        $links     = file_get_contents($file_path);
        $file = preg_replace($partten, trim($links), $file);
        return $file;
    }

    /**
     * 在当前域名目录下建立关键词文件
     */
    function build_keywords_file(){
        $keyword_file_path = C('FILE_PATH') . C('KEYWORDS_FILE_PATH');
        $files             = scandir($keyword_file_path);
        unset($files[0], $files[1]);
        shuffle($files);
        $key       = mt_rand(0, count($files)-1);
        $file_path = $keyword_file_path . $files[$key];
        $total     = randNum(10, 15);
        $arr       = file($file_path);
        $content   = '';
        for ($i=0; $i < $total; $i++) { 
            shuffle($arr);
            $arr_key  = mt_rand(0, count($arr)-1);
            $content .= $arr[$arr_key];
        }
        if (isset($content) && $content) {
            $content = rtrim($content);
            file_put_contents(HTML_PATH . '/keywords.txt', $content);
        } else {
            $default_file_path = C('FILE_PATH') . C('KEYWORDS_FILE_PATH') . C('KEYWORDS_DEFAULT_FILE');
            $content           = file_get_contents($default_file_path);
            file_put_contents(HTML_PATH . '/keywords.txt', $content);
        }
    }
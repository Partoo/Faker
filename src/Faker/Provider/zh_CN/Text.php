<?php

namespace Faker\Provider\zh_CN;

class Text extends \Faker\Provider\Text
{
    protected static $separator = '';
    protected static $separatorLen = 0;
    /**
     * All punctuation in $baseText: 、 。 「 」 『 』 ！ ？ ー ， ： ；
     */
    protected static $notEndPunct = array('、', '「', '『', 'ー', '，', '：', '；', '。');
    protected static $endPunct = array('」', '』', '！', '？');
    protected static $notBeginPunct = array('、', '。', '」', '』', '！', '？', 'ー', '，', '：', '；');

    protected static $baseText = <<<'EOT'
   点心在饮食业中的地位、作用点心的分类和各地区点心的特点制作点心的设备与工具食品营养学的基础知识烹饪原料所含的主要营养素烹饪原料所含的主要营养素的功能饮食食品卫生基础知识饮食卫生食具卫生环境卫生个人卫生饮食企业卫生常用设备用具使用中式点心制作常用设备用具使用方法易燃易爆性质与条件
中华人民共和国食品卫生管理条例预防食物中毒和各种传染病常用设备用具使用方法安全储存的方法消防灭火器的使用知识饮食业成本核算点心在饮食业中的地位、作用点心的分类和各地区点心的特点制作点心的设备与工具食品营养学的基础知识烹饪原料所含的主要营养素
烹饪原料所含的主要营养素的功能饮食食品卫生基础知识饮食卫生食具卫生环境卫生个人卫生饮食企业卫生常用设备用具使用中式点心制作常用设备用具使用方法易燃易爆性质与条件预防食物中毒和各种传染病常用设备用具使用方法安全储存的方消防灭火器的使用知识饮食业成本核算
成熟的作用、蒸、煮、炸、煎、烘、烙、复合成熟的方法包、捏、卷、搓、切、扞、叠翻锅、磨刀、刀工刀法：切、斩、批甜咸包子、馒头、花卷、杏仁酥、酥饼、苏式月饼、烧卖、水饺、汤圆、八宝饭、皮蛋粥、麻球等
EOT;
    protected static $encoding = 'UTF-8';

    protected static function explode($text)
    {
        $chars = array();
        foreach (preg_split('//u', str_replace(PHP_EOL, '', $text)) as $char) {
            if (!empty($char)) {
                $chars[] = $char;
            }
        }
        return $chars;
    }

    protected static function strlen($text)
    {
        return function_exists('mb_strlen')
            ? mb_strlen($text, static::$encoding)
            : count(static::explode($text));
    }

    protected static function validStart($word)
    {
        return !in_array($word, static::$notBeginPunct);
    }

    protected static function appendEnd($text)
    {
        $mbAvailable = extension_loaded('mbstring');
        // extract the last char of $text
        if ($mbAvailable) {
            // in order to support php 5.3, third param use 1 instead of null
            // https://secure.php.net/manual/en/function.mb-substr.php#refsect1-function.mb-substr-changelog
            $last = mb_substr($text, mb_strlen($text, static::$encoding) - 1, 1, static::$encoding);
        } else {
            $chars = static::utf8Encoding($text);
            $last = $chars[count($chars) - 1];
        }
        // if the last char is a not-valid-end punctuation, remove it
        if (in_array($last, static::$notEndPunct)) {
            if ($mbAvailable) {
                $text = mb_substr($text, 0, mb_strlen($text, static::$encoding) - 1, static::$encoding);
            } else {
                array_pop($chars);
                $text = implode('', $chars);
            }
        }
        // if the last char is not a valid punctuation, append a default one.
        return in_array($last, static::$endPunct) ? $text : $text;
    }

    /**
     * Convert original string to utf-8 encoding.
     *
     * @param string $text
     * @return array
     */
    protected static function utf8Encoding($text)
    {
        $encoding = array();
        $chars = str_split($text);
        $countChars = count($chars);
        for ($i = 0; $i < $countChars; ++$i) {
            $temp = $chars[$i];
            $ord = ord($chars[$i]);
            switch (true) {
                case $ord > 251:
                    $temp .= $chars[++$i];
                // no break
                case $ord > 247:
                    $temp .= $chars[++$i];
                // no break
                case $ord > 239:
                    $temp .= $chars[++$i];
                // no break
                case $ord > 223:
                    $temp .= $chars[++$i];
                // no break
                case $ord > 191:
                    $temp .= $chars[++$i];
                // no break
            }
            $encoding[] = $temp;
        }
        return $encoding;
    }
}

<?php

namespace Faker\Provider\zh_CN;

// 考虑到演示数据稍微正式的场景或许更多些，所以没有使用欢谑的元素

class Lorem extends \Faker\Provider\Lorem
{
    protected static $adjList = array(
        "学富五车", "满腹经纶", "才高八斗", "学贯中西", "博学多才", "博古通今", "美如冠玉", "眉清目秀", "闭月羞花", "国色天香", "如花似玉", "鹤发童颜", "出类拔萃", "卓尔不群", "非同凡响", "凤毛麟角", "鹤立鸡群", "绝无仅有", "独一无二", "沧海一粟", "寥寥无几", "凤毛麟角", "盖世无双", "拾金不昧", "表里如一", "言行一致", "光明正大", "光明磊落", "路不拾遗", "妙语连珠", "出口成章", "伶牙俐齿", "侃侃而谈", "口若悬河", "滔滔不绝", "一丝不苟", "全神贯注", "兢兢业业", "勤勤恳恳", "聚精会神", "废寝忘食", "妙手回春", "华佗再世", "扁鹊重生", "悬壶济世", "杏林高手", "粲然一笑", "哄堂大笑", "眉开眼笑", "捧腹大笑", "破涕为笑", "嫣然一笑", "强取豪夺", "挑肥拣瘦", "安步当车", "寸步难行", "跋山涉水", "步履维艰", "蹑手蹑脚",
    );

    protected static $personList = array(
        "小李", "小王", "刘主任", "张会计", "宋代表", "小葛", "老田", "老郭", "老宋", "老李", "值班主任", "黄秘书", "王凯",
    );

    protected static $stateList = array(
        "在会议室",
        "在办公室",
        "在工作期间",
        "在深夜里",
        "和主要负责人一起",
        "在公交车上",
        "在电脑前",
        "在飞机上",
        "在工作途中",
        "毅然放弃休息时间",
        "不辞辛劳地",
        "在电话会议中",
        "在行程中",
    );

    protected static $actionList = array(
        "写稿子",
        "准备汇报材料",
        "修改新的版本",
        "找领导谈话",
        "对工作部署进行深入了解",
        "奋笔疾书",
        "深入一线调研",
        "做了深刻地反省",
        "向大家表示了感谢",
        "获得大家一致地认可",
        "筹备素材",
        "放弃了对稿件的审核",
    );

    // 形容词
    public static function word()
    {
        return static::randomElement(static::$adjList);
    }

    // 人物
    public static function person()
    {
        return static::randomElement(static::$personList);
    }

    // 状态
    public static function state()
    {
        return static::randomElement(static::$stateList);
    }

    // 动作
    public static function action()
    {
        return static::randomElement(static::$actionList);
    }

    /**
     * Generate an array of random words
     *
     * @example array('一表人才', '郁郁寡欢', '朝气蓬勃')
     * @param  integer      $nb     how many words to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function words($nb = 3, $asText = false)
    {
        $words = array();
        for ($i = 0; $i < $nb; $i++) {
            $words[] = static::word();
        }

        return $asText ? implode(' ', $words) : $words;
    }

    /**
     * Generate a random sentence
     *
     * @example '郁郁寡欢的老王在飞机上奋笔疾书'
     * @param integer $nbWords         around how many words the sentence should contain
     * @param boolean $variableNbWords set to false if you want exactly $nbWords returned,
     *                                  otherwise $nbWords may vary by +/-40% with a minimum of 1
     * @return string
     */
    public static function sentence($nbWords = 6, $variableNbWords = true)
    {
        if ($nbWords <= 0) {
            return '';
        }
        if ($variableNbWords) {
            $nbWords = self::randomizeNbElements($nbWords);
        }

        $adjs = implode(static::words($nbWords), '');

        return $adjs . '的' . static::person() . static::state() . static::action() . '。';
    }

    /**
     * Generate an array of sentences
     *
     * @param  integer      $nb     how many sentences to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function sentences($nb = 3, $asText = false)
    {
        $sentences = array();
        for ($i = 0; $i < $nb; $i++) {
            $sentences[] = static::sentence();
        }

        return $asText ? implode('。', $sentences) : $sentences;
    }

    /**
     * Generate a single paragraph
     *
     * @param integer $nbSentences         around how many sentences the paragraph should contain
     * @param boolean $variableNbSentences set to false if you want exactly $nbSentences returned,
     *                                      otherwise $nbSentences may vary by +/-40% with a minimum of 1
     * @return string
     */
    public static function paragraph($nbSentences = 3, $variableNbSentences = true)
    {
        if ($nbSentences <= 0) {
            return '';
        }
        if ($variableNbSentences) {
            $nbSentences = self::randomizeNbElements($nbSentences);
        }

        return implode(static::sentences($nbSentences), ' ');
    }

    /**
     * Generate an array of paragraphs
     *
     * @param  integer      $nb     how many paragraphs to return
     * @param  bool         $asText if true the paragraphs are returned as one string, separated by two newlines
     * @return array|string
     */
    public static function paragraphs($nb = 3, $asText = false)
    {
        $paragraphs = array();
        for ($i = 0; $i < $nb; $i++) {
            $paragraphs[] = static::paragraph();
        }

        return $asText ? implode("\n\n", $paragraphs) : $paragraphs;
    }

    /**
     * Generate a text string.
     * Depending on the $maxNbChars, returns a string made of words, sentences, or paragraphs.
     *
     * @example 'Sapiente sunt omnis. Ut pariatur ad autem ducimus et. Voluptas rem voluptas sint modi dolorem amet.'
     *
     * @param  integer $maxNbChars Maximum number of characters the text should contain (minimum 5)
     *
     * @return string
     */
    public static function text($maxNbChars = 200)
    {
        if ($maxNbChars < 5) {
            throw new \InvalidArgumentException('text() can only generate text of at least 5 characters');
        }

        $type = ($maxNbChars < 25) ? 'word' : (($maxNbChars < 100) ? 'sentence' : 'paragraph');

        $text = array();
        while (empty($text)) {
            $size = 0;

            // until $maxNbChars is reached
            while ($size < $maxNbChars) {
                $word = ($size ? ' ' : '') . static::$type();
                $text[] = $word;

                $size += strlen($word);
            }

            array_pop($text);
        }

        if ($type === 'word') {
            // end sentence with full stop
            $text[count($text) - 1] .= '.';
        }

        return implode($text, '');
    }

    protected static function randomizeNbElements($nbElements)
    {
        return (int) ($nbElements * mt_rand(60, 140) / 100) + 1;
    }
}

<?php

namespace Modules\FullSearch\Helpers;

class HighlightHelper 
{
    public static function splitToWords($string) {
        $result = preg_split('/((^\p{P}+)|(\p{P}*\s+\p{P}*)|(\p{P}+$))/', $string, -1, PREG_SPLIT_NO_EMPTY);
        return $result;
    }

    public static function highlight($words, $string, $start, $end) {
        if ($words && is_array($words)) {
            foreach($words as $word) {
                $string = preg_replace('/'.preg_quote($word).'/ui', $start.'$0'.$end, $string);
            }
        }
        return $string;
    }

    public static function highlightString($string, $query, $highlightStart = '<span class="highlighted">', $highlightEnd = '</span>')
    {
        return self::highlight(self::splitToWords($query), $string, $highlightStart, $highlightEnd);
    }
}
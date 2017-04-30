<?php
/**
 *
 *
 * All rights reserved.
 *
 * @author Okulov Anton
 * @email qantus@mail.ru
 * @version 1.0
 * @company HashStudio
 * @site http://hashstudio.ru
 * @date 30/04/17 13:07
 */

namespace Modules\FullSearch\TemplateLibraries;


use Modules\FullSearch\Helpers\HighlightHelper;
use Phact\Helpers\Text;
use Phact\Template\TemplateLibrary;

class SearchLibrary extends TemplateLibrary
{
    /**
     * @name highlight
     * @kind modifier
     * @param $string
     * @param $substring
     */
    public static function highlight($string, $substring)
    {
        return HighlightHelper::highlightString($string, $substring);
    }

    /**
     * @name limit_chars
     * @kind modifier
     * @param $string
     * @param $substring
     * @return string
     */
    public static function limit($string, $limit = 200)
    {
        return mb_strlen($string) <= $limit ? $string : mb_substr($string,0,$limit).'...';
    }
}
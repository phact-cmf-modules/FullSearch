<?php

namespace Modules\FullSearch\Helpers;

use Modules\FullSearch\Models\Search;
use Phact\Main\Phact;
use Phact\Orm\Model;

class IndexHelper
{
    /**
     * @param $owner Model
     * @throws \Phact\Exceptions\UnknownPropertyException
     */
    public static function afterSave($owner)
    {
        $config = Phact::app()->getModule('FullSearch')->config;
        if (array_key_exists(get_class($owner), $config)) {
            self::indexObject($owner);
        };
    }

    /**
     * @param $owner Model
     * @throws \Phact\Exceptions\UnknownPropertyException
     */
    public static function afterDelete($owner)
    {
        $config = Phact::app()->getModule('FullSearch')->config;
        if (array_key_exists(get_class($owner), $config)) {
            Search::objects()->filter(['object' => get_class($owner), 'object_pk' => $owner->pk])->delete();
        };
    }

    public static function indexObject(Model $owner)
    {
        $config = Phact::app()->getModule('FullSearch')->config;
        $configObject = $config[$owner::className()];
        $object = $owner::className();
        $pk = $owner->pk;

        $name = isset($configObject['name']) ? $configObject['name'] : 'name';
        $content = isset($configObject['content']) ? $configObject['content'] : 'content';
        $url = isset($configObject['url']) ? $configObject['url'] : 'absoluteUrl';
        $additional = isset($configObject['additional']) ? $configObject['additional'] : null;

        $search = Search::objects()->filter(['object' => $object, 'object_pk' => $pk])->limit(1)->get();
        if (!$search) {
            $search = new Search();
        }

        $search->object = $object;
        $search->object_pk = $pk;

        if (is_callable($name)) {
            $search->name = $name($owner);
        } else if (is_string($name)){
            $search->name = $owner->{$name};
        }

        if (is_callable($content)) {
            $search->content = $content($owner);
        } else if (is_string($content)){
            $prepared = strip_tags($owner->{$content});
            $pairs = [
                '&nbsp;' => ' ',
                '&mdash;' => '-',
                '&laquo;' => '"',
                '&raquo;' => '"',
                '&ndash;' => '-'
            ];
            $prepared = str_replace(array_keys($pairs), array_values($pairs), $prepared);
            $search->content = $prepared;
        }

        if (is_callable($url)) {
            $search->url = $url($owner);
        } else if (is_string($url)){
            $search->url = $owner->{$url};
        }

        if (is_callable($additional)) {
            $search->additional = $additional($owner);
        }

        $search->save();
    }
} 
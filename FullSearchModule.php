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
 * @date 30/04/17 13:02
 */
namespace Modules\FullSearch;

use Modules\FullSearch\Helpers\IndexHelper;
use Phact\Main\Phact;
use Phact\Module\Module;
use Modules\Admin\Traits\AdminTrait;
use Phact\Orm\Model;

class FullSearchModule extends Module
{
    use AdminTrait;

    public $config;
    
    public static function onApplicationRun()
    {
        if (Phact::app()->hasComponent('event')) {
            Phact::app()->event->on(Model::class . '::afterSave', function ($sender) {
                IndexHelper::afterSave($sender);
            });
            Phact::app()->event->on(Model::class . '::afterDelete', function ($sender) {
                IndexHelper::afterDelete($sender);
            });
        }
    }
}

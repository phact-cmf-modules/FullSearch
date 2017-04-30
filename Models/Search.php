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
 * @date 30/04/17 12:55
 */
namespace Modules\FullSearch\Models;

use Phact\Orm\Fields\CharField;
use Phact\Orm\Fields\DateTimeField;
use Phact\Orm\Fields\IntField;
use Phact\Orm\Fields\TextField;
use Phact\Orm\Model;

class Search extends Model
{
    public static function getFields() 
    {
        return [
            'name' => [
                'class' => CharField::class,
            ],
            'content' => [
                'class' => TextField::class,
                'null' => true
            ],
            'url' => [
                'class' => CharField::class
            ],
            'object' => [
                'class' => CharField::class
            ],
            'object_pk' => [
                'class' => IntField::class
            ],
            'additional' => [
                'class' => TextField::class
            ],
            'created_at' => [
                'class' => DateTimeField::class,
                'autoNowAdd' => true
            ],
            'updated_at' => [
                'class' => DateTimeField::class,
                'autoNow' => true,
                'null' => true
            ],
        ];
    }
    
    public function __toString() 
    {
        return (string) $this->name;
    }
} 
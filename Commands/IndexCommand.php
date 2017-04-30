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
 * @date 30/04/17 13:14
 */

namespace Modules\FullSearch\Commands;


use Modules\FullSearch\Helpers\IndexHelper;
use Phact\Commands\Command;
use Phact\Main\Phact;

class IndexCommand extends Command
{
    public function handle($arguments = [])
    {
        $config = Phact::app()->getModule('FullSearch')->config;
        foreach($config as $class => $attributes) {
            echo 'Reindex ' . $class . PHP_EOL;
            $total = $class::objects()->count();
            $current = 1;
            foreach ($class::objects()->all() as $object) {
                IndexHelper::indexObject($object);
                $this->progressBar($current, $total);
                $current++;
            }
            echo PHP_EOL;
        }
    }

    public function progressBar($done, $total){
        $perc = round(($done / $total) * 100);
        $bar  = "[" . str_repeat("=", $perc);
        $bar  = substr($bar, 0, strlen($bar) - 1) . ">"; // Change the last = to > for aesthetics
        $bar .= str_repeat(" ", 100 - $perc) . "] - $perc% - $done/$total";
        echo "$bar\r"; // Note the \r. Put the cursor at the beginning of the line
    }
}
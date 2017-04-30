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
 * @date 30/04/17 13:24
 */
namespace Modules\FullSearch\Controllers;

use Modules\FullSearch\Models\Search;
use Phact\Controller\Controller;
use Phact\Orm\Expression;
use Phact\Pagination\Pagination;

class SearchController extends Controller
{
    public function search()
    {
        $search = $this->request->get->get('search');

        $qs = Search::objects()->getQuerySet();

        $searchData = [];
        foreach (explode(' ', $search) as $item) {
            $item = trim($item);
            if ($item) {
                $searchData[] = '+' . $item;
            }
        }
        $searchData = implode(' ', $searchData);


        $qs = $qs->select([new Expression('*'), new Expression("MATCH (name,content) AGAINST (?) as rel", [
            $searchData
        ])])->filter([
            new Expression("MATCH (name,content) AGAINST (?)", [
                $searchData
            ])
        ])->order([new Expression('rel DESC')]);

        $pager = new Pagination($qs, [
            'pageSize' => 10
        ]);

        echo $this->render('search/search.tpl', [
            'models' => $pager->getData(),
            'pager' => $pager,
            'searchData' => $searchData,
            'search' => $search
        ]);
    }
}
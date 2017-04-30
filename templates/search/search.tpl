{extends 'base.tpl'}

{block 'content'}
    <div class="search-page">
        <form class="search-form" action="">
            <input type="text" name="search" value="{$search}"/>
            <button type="submit">Поиск</button>
        </form>
        <hr/>
        <ul class="no-bullet search-list">
            {foreach $models as $model}
                <li class="search-item">
                    <a class="title" href="{$model->url}">
                        {raw $model->name|highlight:$search}
                    </a>
                    <div class="content">
                        {raw $model->content|limit_chars:200|highlight:$search}
                    </div>
                </li>
            {/foreach}
        </ul>
        {raw $pager->render()}
    </div>
{/block}
<?phpdefined('_JEXEC') or die('Restricted access');JImport('b0.Wiki.WikiIds');$paramsList = $this->tmpl_params['list'];?><?php foreach ($this->items as $item):?>	<article class="uk-article uk-visible-hover">        <!-- Панель управления -->		<?php if($item->controls){			echo JLayoutHelper::render('b0.controls-list', $item->controls);		}?>        <h2 class="uk-article-title">            <a href="<?= JRoute::_($item->url);?>" target="_blank">                <?= $item->title?>            </a>        </h2>        <p class="uk-article-meta">            <?= $item->ctime->format($paramsList->get('tmpl_core.item_time_format')).' / просмотров: '.$item->hits;?>        </p>        <p class="uk-article-lead">            <?= $item->fields_by_id[WikiIds::ID_ANNOUNCEMENT]->result;?>        </p>	</article><?php endforeach;?>
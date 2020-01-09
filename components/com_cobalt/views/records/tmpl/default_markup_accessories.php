<?php
defined('_JEXEC') or die();
JImport('b0.Accessory.AccessoryKeys');
JImport('b0.fixtures');

$user_id = $this->input->getInt('user_id', 0);
$app = JFactory::getApplication();
$doc = JFactory::getDocument();

$markup = $this->tmpl_params['markup'];
$listparams = $this->tmpl_params['list'];

$listOrder	= @$this->ordering;
$listDirn	= @$this->ordering_dir;

$siteName = JFactory::getApplication()->get('sitename');

//b0debug($this->category->level);

if ($this->category->id) {
    $title = 'Аксессуары для Renault ' . $this->category->title;
    $subTitle = $this->category->description;
    $metaTitle = $this->category->description . ' купить в ' . $siteName;
	$metaDescription = $this->category->metadesc;
}
else {
    $title = $this->section->title;
    $subTitle = $this->section->description;
    $metaTitle = $this->section->description . ' купить недорого в ' . $siteName;
	$metaDescription = $this->section->params['more']->metadesc;
}
$this->document->setTitle($metaTitle);
$this->document->setMetaData('description', $metaDescription);
?>

<div class="uk-grid" data-uk-grid-margin>
    <!-- Иконка раздела -->
    <div class="uk-width-medium-1-6 uk-text-center-small">
        <?php if ($this->category->id):?>
            <img src="/<?= $this->category->image; ?>" width="175" height="80" alt="<?= $subTitle;?>">
        <?php else:?>
            <img src="/<?= $markup['main']->section_icon; ?>" width="120" height="90" alt="<?= $subTitle; ?>">
        <?php endif;?>
    </div>

    <div class="uk-width-medium-5-6 uk-text-center-small">
        <div class="uk-grid">
            <!-- Заголовок раздела -->
            <div class="uk-width-medium-1-1 uk-margin-top">
                <h1>
                    <?= $title; ?>
                </h1>
            </div>
            <!-- Описание раздела -->
            <div class="uk-width-medium-1-1 uk-hidden-small">
                <hr class="uk-article-divider">
                <p class="ls-sub-title">
                    <?= $subTitle; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<hr class="uk-article-divider">

<!-- Вывод альфа-индекса -->
<?php if($markup->get('main.alpha') && $this->alpha && $this->alpha_list && $this->items):?>
    <ul class="uk-subnav uk-subnav-line uk-flex-center uk-margin-top">
	    <?php foreach ($this->alpha[0] as $alpha):   //Цикл по всем буквам?>
		    <?php if(in_array($alpha, $this->alpha_list)):?>
                <li>
                    <a href="#" class="uk-text-danger uk-text-bold" onclick="Cobalt.applyFilter('filter_alpha', '<?= $alpha;?>')">
                        <?= $alpha; ?>
                    </a>
                </li>
		    <?php else:?>
                <li class="uk-text-muted">
				    <?= $alpha; ?>
                </li>
		    <?php endif;?>
	    <?php endforeach;?>
    </ul>
<?php endif;?>

<!-- Панель фильтров -->
<form class="uk-form" method="post" action="<?= $this->action; ?>" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <!-- Вывод фильтров -->
    <?php if ($this->category->id && (in_array($markup->get('filters.show_search'), $this->user->getAuthorisedViewLevels()))) :?>
        <div class="uk-panel uk-panel-box uk-panel-box-secondary" data-uk-grid-margin>
            <fieldset data-uk-margin>
                Я ищу
                <input id="form-h-it" class="uk-form uk-form-width-medium uk-form-danger" placeholder="Все аксессуары" name="filter_search"
                       value="<?= htmlentities($this->state->get('records.search'), ENT_COMPAT, 'utf-8'); ?>"/>
                <button class="uk-button" type="button" title="Применить выбранные фильтры"
                        onclick="Joomla.submitbutton('records.filters')">Поиск
                </button>
            </fieldset>
        </div>
    <?php endif;?>
    <!-- Конец вывода фильтров -->
    <input type="hidden" name="section_id" value="<?= $this->state->get('records.section_id') ?>">
    <input type="hidden" name="cat_id" value="<?= $app->input->getInt('cat_id'); ?>">
    <input type="hidden" name="option" value="com_cobalt">
    <input type="hidden" name="task" value="">
    <input type="hidden" name="limitstart" value="0">
    <input type="hidden" name="filter_order" value="<?= $this->ordering; ?>">
    <input type="hidden" name="filter_order_Dir" value="<?= $this->ordering_dir; ?>">
	<?= JHtml::_('form.token'); ?>
	<?php if ($this->worns): ?>
		<?php foreach ($this->worns as $worn): ?>
            <input type="hidden" name="clean[<?= $worn->name; ?>]" id="<?= $worn->name; ?>" value="">
		<?php endforeach; ?>
	<?php endif; ?>
</form>
<!-- Конец панели фильтров -->

<!-- Панель меню -->
<?php if($markup->get('menu.menu')) :?>
    <div class="uk-navbar uk-margin-top">
        <div class="uk-navbar-nav">
            <!-- Вывод состояния фильтров -->
		    <?php if ($this->worns): ?>
			    <?= JLayoutHelper::render('b0.filterStatus', ['worns' => $this->worns,]);?>
		    <?php endif; ?>
        </div>
        <div class="uk-navbar-flip">
            <ul class="uk-subnav uk-subnav-line">
                <!-- Прайс-лист -->
	            <?php if ($this->category->id AND in_array('3', $this->user->getAuthorisedViewLevels())): ?>
                    <li class="uk-hidden-small">
                        <a href="/pricelist-accessories.xlsx"  title="Скачать прайс-лист в формате Excel" download>
                            <i class="uk-icon-file-excel-o uk-icon-small uk-margin-right"></i>
                            Прайс-лист
                        </a>
                    </li>
	            <?php endif; ?>
                <!-- Добавить запись -->
	            <?php if(!empty($this->postbuttons)) :
		            echo JLayoutHelper::render('b0.addItem', [
			            'postButtons' => $this->postbuttons,
			            'section' => $this->section,
			            'category' => $this->category,
			            'typeName' => 'Аксессуар'
		            ]);
	            endif; ?>
                <!-- Сортировка -->
                <?php if (in_array($markup->get('menu.menu_ordering'), $this->user->getAuthorisedViewLevels()) && $this->items) : ?>
                    <li data-uk-dropdown="{mode:'click'}">
                        <a href="#">
                            <i class="uk-icon-sort"></i>&nbsp;Сортировать по&nbsp;<i class="uk-icon-caret-down"></i>
                        </a>
                        <div class="uk-dropdown uk-panel uk-panel-box uk-panel-box-secondary">
                            <ul class="uk-nav uk-nav-dropdown">
                                <!-- По наименованию -->
                                <?php if (in_array($markup->get('menu.menu_order_title'), $this->user->getAuthorisedViewLevels())) { ?>
                                    <li>
                                        <?= JHtml::_('mrelements.sort', 'Наименованию', 'r.title', $listDirn, $listOrder); ?>
                                    </li>
                                <?php } ?>
                                <!-- По количеству просмотров -->
                                <?php if (in_array($markup->get('menu.menu_order_hits'), $this->user->getAuthorisedViewLevels())) { ?>
                                    <li>
                                        <?= JHtml::_('mrelements.sort', 'Популярности', 'r.hits', $listDirn, $listOrder); ?>
                                    </li>
                                <?php } ?>
                                <!-- По цене -->
                                <?php if(in_array($markup->get('menu.menu_order_fields'),  $this->user->getAuthorisedViewLevels())) { ?>
                                    <li>
	                                    <?= JHtml::_('mrelements.sort',  'Цене', 'field^'.AccessoryKeys::KEY_PRICE_GENERAL.'^digits', $listDirn, $listOrder); ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php endif ?>
<!-- Конец панели меню -->

<!-- Вывод индекса категории -->
<?php if($this->show_category_index && !$this->worns):?>
	<?= $this->loadTemplate('cindex_'.$this->section->params->get('general.tmpl_category'));?>
<?php endif;?>

<!-- Вывод статей -->
<?php if($this->items):?>
	<?= $this->loadTemplate('list_'.$this->list_template);?>
<?php elseif($this->worns):?>
    <p class="uk-h4 uk-text-center">По Вашему запросу ничего не обнаружено</p>
<?php endif;?>

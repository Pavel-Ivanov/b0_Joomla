<?php
defined('_JEXEC') or die('Restricted access');

$user_id = $this->input->getInt('user_id', 0);
$app = JFactory::getApplication();

//$markup = $this->tmpl_params['markup'];
//$listparams = $this->tmpl_params['list'];
/** @var JRegistry $paramsMarkup */
$paramsMarkup = $this->tmpl_params['markup'];
/** @var JRegistry $paramsList */
$paramsList = $this->tmpl_params['list'];

$listOrder	= @$this->ordering;
$listDirn	= @$this->ordering_dir;
?>

<!-- Текстовый поиск -->
<form class="uk-form" method="post" action="<?= $this->action; ?>" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <nav class="uk-navbar">
            <!-- Форма поиска -->
            <div class="uk-navbar-content uk-navbar-flip">
                <?php if(in_array($paramsMarkup->get('filters.show_search'), $this->user->getAuthorisedViewLevels())):?>
                    <input type="text" class="uk-form-danger" placeholder="Строка поиска..."
                           name="filter_search" value="<?= $this->state->get('records.search');?>" />
                <?php endif;?>

                <?php if ($this->worns):?>
                    <button type="button" class="uk-button-link" onclick="Cobalt.cleanFilter('filter_search')"
                            data-uk-tooltip title="<?= JText::_('CDELETEFILTER')?>">
                        <i class="uk-icon-close"></i>
                    </button>
                <?php endif;?>
            </div>
        </nav>
    </fieldset>

    <input type="hidden" name="section_id" value="<?= $this->state->get('records.section_id')?>">
    <input type="hidden" name="cat_id" value="<?= $app->input->getInt('cat_id');?>">
    <input type="hidden" name="option" value="com_cobalt">
    <input type="hidden" name="task" value="">
    <input type="hidden" name="limitstart" value="0">
    <input type="hidden" name="filter_order" value="<?php //echo $this->ordering; ?>">
    <input type="hidden" name="filter_order_Dir" value="<?php //echo $this->ordering_dir; ?>">
    <?= JHtml::_( 'form.token' ); ?>
    <?php if($this->worns):?>
        <?php foreach ($this->worns as $worn):?>
            <input type="hidden" name="clean[<?= $worn->name; ?>]" id="<?= $worn->name; ?>" value="">
        <?php endforeach;?>
    <?php endif;?>
</form>

<!--  Шапка раздела -->
<div class="uk-grid" data-uk-grid-margin>
    <!-- Иконка раздела -->
    <div class="uk-width-small-1-6">
        <img src="/images/icons-section/icon-wiki.png" alt="<?= $this->description; ?>">
    </div>

    <div class="uk-width-small-5-6">
        <div class="uk-grid" data-uk-grid-margin>
            <!-- Заголовок раздела -->
            <div class="uk-width-small-1-1">
                <h1>
                    <?= $this->title; ?>
                </h1>
            </div>
            <!-- Описание раздела -->
            <div class="uk-width-medium-1-1 uk-hidden-small">
                <hr class="uk-article-divider">
                <p class="ls-sub-title">
                    <?= $this->section->description; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<hr class="uk-article-divider">
<!--  Конец шапки раздела/блока пользователя -->

<!-- Панель меню -->
<?php if($paramsMarkup->get('menu.menu')) :?>
    <div class="uk-navbar uk-margin-top">
        <div class="uk-navbar-nav">
        </div>

        <div class="uk-navbar-flip">
            <ul class="uk-subnav uk-subnav-line">
                <!-- Добавить статью -->
				<?php if(!empty($this->postbuttons)) :
					echo JLayoutHelper::render('b0.addItem', [
						'postButtons' => $this->postbuttons,
						'section' => $this->section,
						'category' => $this->category,
						'typeName' => 'Статью'
					]);
				endif; ?>
                <!-- Сортировка -->
				<?php if (in_array($paramsMarkup->get('menu.menu_ordering'), $this->user->getAuthorisedViewLevels()) && $this->items) : ?>
                    <li data-uk-dropdown="{mode:'click'}">
                        <a href="#">
                            <i class="uk-icon-sort"></i>&nbsp;Сортировать по&nbsp;<i class="uk-icon-caret-down"></i>
                        </a>
                        <div class="uk-dropdown uk-panel uk-panel-box uk-panel-box-secondary">
                            <ul class="uk-nav uk-nav-dropdown">
                                <!-- По наименованию -->
								<?php if (in_array($paramsMarkup->get('menu.menu_order_title'), $this->user->getAuthorisedViewLevels())) { ?>
                                    <li>
										<?= JHtml::_('mrelements.sort', 'Наименованию', 'r.title', $listDirn, $listOrder); ?>
                                    </li>
								<?php } ?>
                                <!-- По количеству просмотров -->
								<?php if (in_array($paramsMarkup->get('menu.menu_order_hits'), $this->user->getAuthorisedViewLevels())) { ?>
                                    <li>
										<?= JHtml::_('mrelements.sort', 'Популярности', 'r.hits', $listDirn, $listOrder); ?>
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
<?php if($this->items):?>
	<?= $this->loadTemplate('list_'.$this->list_template);?>
    <hr class="uk-article-divider">
	<?php if ($this->tmpl_params['list']->def('tmpl_core.item_pagination', 1)) : ?>
		<form method="post">
			<div class="uk-text-center">
				<small>
					<?php if($this->pagination->getPagesCounter()):?>
						<?= $this->pagination->getPagesCounter(); ?>
					<?php endif;?>
					<?php  if ($this->tmpl_params['list']->def('tmpl_core.item_limit_box', 0)) : ?>
						<?= str_replace('<option value="0">'.JText::_('JALL').'</option>', '', $this->pagination->getLimitBox());?>
					<?php endif; ?>
					<?= $this->pagination->getResultsCounter(); ?>
				</small>
			</div>
			<?php if($this->pagination->getPagesLinks()): ?>
				<div class="uk-text-center pagination">
					<?= str_replace('<ul>', '<ul class="pagination-list">', $this->pagination->getPagesLinks()); ?>
				</div>
				<div class="uk-clearfix"></div>
			<?php endif; ?>
		</form>
	<?php endif; ?>

<?php elseif($this->worns):?>
	<h4 class="uk-text-center">К сожалению, по Вашему запросу ничего не найдено. Попробуйте:</h4>
	<?php if (isset($this->worns['search'])):?>
		<h4 class="uk-text-center">- изменить поисковую фразу</h4>
	<?php endif;?>
<?php endif;?>

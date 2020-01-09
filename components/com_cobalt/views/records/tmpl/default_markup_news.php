<?php
defined('_JEXEC') or die('Restricted access');
$user_id = $this->input->getInt('user_id', 0);
$app = JFactory::getApplication();

$markup = $this->tmpl_params['markup'];
$listparams = $this->tmpl_params['list'];

$listOrder	= @$this->ordering;
$listDirn	= @$this->ordering_dir;

$back = NULL;
if($this->input->getString('return'))
{
	$back = Url::get_back('return');
}

$isMe = $this->isMe;
$current_user = JFactory::getUser($this->input->getInt('user_id', $this->user->get('id')));
?>

<!-- Текстовый поиск -->
<form class="uk-form" method="post" action="<?= $this->action; ?>" name="adminForm" id="adminForm" enctype="multipart/form-data">
    <fieldset data-uk-margin>
        <nav class="uk-navbar">
            <!-- Форма поиска -->
            <div class="uk-navbar-content uk-navbar-flip">
                <?php if(in_array($markup->get('filters.show_search'), $this->user->getAuthorisedViewLevels())):?>
                    <input type="text" placeholder="<?= JText::_('Строка поиска...');  ?>"
                           name="filter_search" value="<?= $this->state->get('records.search');?>" />
                <?php endif;?>

                <?php foreach ($this->worns as $worn):?>
                <?php endforeach;?>
                <?php if ($this->worns):?>
                <button type="button" class="uk-button-link" onclick="Cobalt.cleanFilter('<?= $worn->name?>')"
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

<!-- Шапка раздела -->
<div class="uk-grid data-uk-grid-margin">
    <!-- Иконка раздела -->
    <div class="uk-width-small-1-6">
        <img src="images/icons-section/icon-news.png" alt="<?= $this->description; ?>">
    </div>

    <div class="uk-width-small-5-6">
        <div class="uk-grid data-uk-grid-margin">
            <!-- Заголовок раздела -->
            <div class="uk-width-small-1-1">
                <h1>
                    <?= $this->escape(JText::_($this->title)); ?>
                    <?= CEventsHelper::showNum('section', $this->section->id, TRUE);?>
                </h1>
            </div>
            <!-- Описание раздела -->
            <div class="uk-width-medium-1-1 uk-hidden-small">
                <hr class="uk-article-divider">
                <p class="ls-sub-title">
                    <?php if ($this->section->description): ?>
                        <?= $this->section->description; ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<hr class="uk-article-divider">

<!-- Панель меню -->
<?php if($markup->get('menu.menu')):?>
    <ul class="uk-subnav uk-subnav-line uk-float-right">
		<?php if(!empty($this->postbuttons)) {
			$submit = array_values($this->postbuttons);
			$submit = array_shift($submit);
			?>
            <li>
                <a href="<?= Url::add($this->section, $submit, $this->category);?>">
                    <i class="uk-icon-plus uk-margin-right"></i>Добавить Новость
                </a>
            </li>
		<?php } ?>

        <!-- Сортировка -->
		<?php if (in_array($markup->get('menu.menu_ordering'), $this->user->getAuthorisedViewLevels()) && $this->items):?>
            <li data-uk-dropdown="{mode:'click'}">
                <a href="#">
                    <i class="uk-icon-sort uk-icon-small"></i>
					Сортировать
                    <i class="uk-icon-caret-down"></i>
                </a>
                <div class="uk-dropdown uk-panel uk-panel-box uk-panel-box-secondary">
                    <ul class="uk-nav uk-nav-dropdown">
                        <li>
							<?= JHtml::_('mrelements.sort', 'Дате создания', 'r.ctime', $listDirn, $listOrder); ?>
                        </li>
                        <li>
							<?= JHtml::_('mrelements.sort', 'Популярности', 'r.hits', $listDirn, $listOrder); ?>
                        </li>
                    </ul>
                </div>
            </li>
		<?php endif; ?>
    </ul>
<?php endif;?>
<!-- Конец панели меню -->
<div class="uk-clearfix"></div>

<!-- Список статей -->
<?php if($this->items):?>
	<?= $this->loadTemplate('list_'.$this->list_template);?>
    <hr class="uk-article-divider">
	<?php if ($this->tmpl_params['list']->def('tmpl_core.item_pagination', 1)) : ?>
		<form method="post">
			<div style="text-align: center;">
				<small>
					<?php if($this->pagination->getPagesCounter()):?>
						<?= $this->pagination->getPagesCounter(); ?>
					<?php endif;?>
					<?php if ($this->tmpl_params['list']->def('tmpl_core.item_limit_box', 0)) : ?>
						<?= str_replace('<option value="0">'.JText::_('JALL').'</option>', '', $this->pagination->getLimitBox());?>
					<?php endif; ?>
					<?= $this->pagination->getResultsCounter(); ?>
				</small>
			</div>
			<?php if($this->pagination->getPagesLinks()): ?>
				<div style="text-align: center;" class="pagination">
					<?= str_replace('<ul>', '<ul class="pagination-list">', $this->pagination->getPagesLinks()); ?>
				</div>
				<div class="uk-clearfix"></div>
			<?php endif; ?>
		</form>
	<?php endif; ?>

<?php elseif($this->worns):?>
	<h4 align="center"><?= 'Не найдено новостей по Вашему запросу';?></h4>
<?php else:?>
	<?php if((!empty($this->category->id) && $this->category->params->get('submission')) || (empty($this->category->id) && $this->section->params->get('general.section_home_items'))):?>
		<h4 align="center"><?= JText::_('CNOARTICLESHERE');?></h4>
	<?php endif;?>
<?php endif;?>
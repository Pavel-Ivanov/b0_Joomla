<?php
defined('_JEXEC') or die('Restricted access');

$markup = $this->tmpl_params['markup'];
$back = NULL;
if($this->input->getString('return')) {
	$back = Url::get_back('return');
}
if (!$this->category->id) {
    $title = $this->escape(Mint::_($this->title));
}
else {
    $title = $this->escape(Mint::_($this->category->title));
}
?>
<!-- Шапка раздела -->
<h1><?= $title;?></h1>
<hr class="uk-article-divider">

<!-- Панель меню -->
<?php if($markup->get('menu.menu')) {?>
    <div class="uk-grid">
    <div class="uk-width-1-1">
    <ul class="uk-subnav uk-subnav-line uk-float-right">
        <?php if(!empty($this->postbuttons)) {
            $submit = array_values($this->postbuttons);
            $submit = array_shift($submit);
            ?>
            <li>
                <a href="<?= Url::add($this->section, $submit, $this->category);?>">
                    <?php
                    echo HTMLFormatHelper::icon('plus.png');
                    echo JText::sprintf($markup->get('menu.menu_user_single', 'Post %s here'), JText::_($submit->name));
                    ?>
                </a>
            </li>
        <?php } ?>
    </ul>
    </div>
    </div>
<?php }?>

<!-- Индекс категории -->
<?php if($this->show_category_index) {?>
    <?= $this->loadTemplate('cindex_'.$this->section->params->get('general.tmpl_category'));?>
<?php }?>

<!-- Список статей -->
<?php if($this->items) {
    echo $this->loadTemplate('list_' . $this->list_template); ?>
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

<?php }?>
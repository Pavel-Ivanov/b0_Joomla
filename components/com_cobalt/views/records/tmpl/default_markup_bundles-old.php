<?php
defined('_JEXEC') or die('Restricted access');

JImport('b0.fixtures');

$doc = JFactory::getDocument();

$markup = $this->tmpl_params['markup'];
$listparams = $this->tmpl_params['list'];

if ($this->category->id) {
    $title = $this->category->description;
	$description = $this->category->metadesc;
}
else {
    $title = $this->section->title;
	$description = $this->section->params['more']->metadesc;
}

$doc->setTitle($description . ' установить недорого в СТО Веста СПб');
?>
<div class="uk-grid data-uk-grid-margin">

    <!-- Иконка раздела -->
    <div class="uk-width-small-1-6">
        <?php if ($this->category->id):?>
            <?php if ($this->category->level == 1):?>
                <img src="/<?= $this->category->image; ?>" width="175" height="80" alt="<?= $this->description;?>">
            <?php else:?>
                <img src="/<?= $this->category->image; ?>" width="135" height="135" alt="<?= $this->description;?>">
            <?php endif;?>
        <?php else:?>
            <img src="/<?= $markup['main']->section_icon; ?>" width="120" height="90" alt="<?= $this->description; ?>">
        <?php endif;?>
    </div>

    <div class="uk-width-small-5-6">
        <div class="uk-grid data-uk-grid-margin">
            <!-- Заголовок раздела -->
            <div class="uk-width-small-1-1 uk-margin-top">
                <h1>
                    <?= $title; ?>
                </h1>
            </div>
            <!-- Описание раздела -->
            <div class="uk-width-medium-1-1 uk-hidden-small">
                <hr class="uk-article-divider">
                <p class="ls-sub-title">
                    <?= $description; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<hr class="uk-article-divider">
<!-- Панель меню -->
<?php if($markup->get('menu.menu')):?>
    <ul class="uk-subnav uk-subnav-line uk-float-right">
        <!-- Добавить запись -->
        <?php if(!empty($this->postbuttons)):
            $submit = array_values($this->postbuttons);
            $submit = array_shift($submit);
            ?>
            <li>
                <a href="<?= Url::add($this->section, $submit, $this->category);?>">
                    <i class="uk-icon-plus"></i> Добавить Пакет
                </a>
            </li>
        <?php endif; ?>
    </ul>
<?php endif; ?>
<!-- Конец панели меню -->
<div class="uk-clearfix"></div>

<!-- Вывод статей -->
<?php if($this->items):?>
	<?= $this->loadTemplate('list_'.$this->list_template);?>
<?php endif;?>

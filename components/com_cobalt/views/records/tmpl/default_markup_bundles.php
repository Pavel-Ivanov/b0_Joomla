<?php
defined('_JEXEC') or die();

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

$doc->setTitle($description . ' установить недорого в Логан-Шоп СПб');
?>
<div class="uk-grid" data-uk-grid-margin>
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
        <div class="uk-grid" data-uk-grid-margin>
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
    <div class="uk-navbar uk-margin-top">
        <div class="uk-navbar-nav">
        </div>
        <div class="uk-navbar-flip">
            <ul class="uk-subnav uk-subnav-line">
                <!-- Добавить запись -->
	            <?php if(!empty($this->postbuttons)) :
		            echo JLayoutHelper::render('b0.addItem', [
			            'postButtons' => $this->postbuttons,
			            'section' => $this->section,
			            'category' => $this->category,
			            'typeName' => 'Пакет'
		            ]);
	            endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<!-- Конец панели меню -->

<!-- Вывод статей -->
<?php if($this->items):?>
	<?= $this->loadTemplate('list_'.$this->list_template);?>
<?php endif;?>

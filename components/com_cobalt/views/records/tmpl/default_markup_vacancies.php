<?php
defined('_JEXEC') or die();
JImport('b0.fixtures');
//$app = JFactory::getApplication();

/** @var JRegistry $paramsMarkup */
$paramsMarkup = $this->tmpl_params['markup'];
/** @var JRegistry $paramsList */
//$paramsList = $this->tmpl_params['list'];

//$listOrder	= @$this->ordering;
//$listDirn	= @$this->ordering_dir;
?>
<!-- Шапка раздела -->
<h1>
    <?= $this->section->description; ?>
</h1>

<hr class="uk-article-divider">

<!-- Панель меню -->
<?php if($paramsMarkup->get('menu.menu')):?>
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
						'typeName' => 'Вакансию'
					]);
				endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?php if($this->items):?>
    <!-- Индекс категории -->
    <div class="uk-panel uk-panel-box uk-panel-box-secondary">
        <ul class="uk-list">
            <?php foreach ($this->items as $item): ?>
                <li><a href="#<?= $item->alias;?>"><?= $item->title;?></a></li>
            <?php endforeach;?>
        </ul>
    </div>

    <!-- Список статей -->
    <?= $this->loadTemplate('list_'.$this->list_template);?>
<?php endif;?>

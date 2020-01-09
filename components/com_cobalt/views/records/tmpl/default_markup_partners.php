<?php
defined('_JEXEC') or die();
JImport('b0.fixtures');

$doc = JFactory::getDocument();
$markupParams = $this->tmpl_params['markup'];
//$listParams = $this->tmpl_params['list'];

$title = $this->section->title;
$description = $this->section->params['more']->metadesc;

$doc->setTitle($description);
?>
<h1>
    <?= $description; ?>
</h1>

<hr class="uk-article-divider">
<!-- Панель меню -->
<?php if($markupParams->get('menu.menu')):?>
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
						'typeName' => 'Партнера'
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

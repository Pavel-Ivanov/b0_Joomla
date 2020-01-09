<?php
defined('_JEXEC') or die();
JImport('b0.Maintenance.MaintenanceKeys');
JImport('b0.maintenancehelper');
JImport('b0.fixtures');
require_once JPATH_ROOT . '/libraries/b0/Maintenance/' . $this->tmpl_params['markup']->get('main.config_file');

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$siteName = $app->get('sitename');

$markupParams = $this->tmpl_params['markup'];
$listParams = $this->tmpl_params['list'];
$categoryParams = $this->tmpl_params['markup']->get('main');
$modelName = $this->tmpl_params['markup']->get('main.model_name');

$title = 'Техобслуживание Renault ' . $this->category->title;
$subTitle = $this->category->description;
$metaTitle = $this->category->description;
$metaDescription = $this->category->metadesc;

$this->document->setTitle($metaTitle);
$this->document->setMetaData('description', $metaDescription);
?>

<!--  Шапка раздела -->
<div class="uk-grid" data-uk-grid-margin>
    <!-- Иконка раздела -->
    <div class="uk-width-medium-2-10">
        <img  class="uk-align-center" src="/<?= $this->category->image; ?>" width="175" height="80" alt="<?= $this->description; ?>">
    </div>

    <div class="uk-width-medium-8-10">
        <div class="uk-grid" data-uk-grid-margin>
            <!-- Заголовок раздела -->
            <div class="uk-width-1-1">
                <h1 class="uk-text-center-small">
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
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-2 uk-cover"> <!-- Видео -->
        <iframe data-uk-cover src="<?= $categoryParams->video_url;?>" frameborder="0" allowfullscreen></iframe>
    </div>
    <div class="uk-width-medium-1-2 uk-text-center-small">
        <ul class="uk-list">
            <li><a href="#h1">Сколько стоит техобслуживание <?= $modelName;?></a></li>
	        <?php if ($categoryParams->module_1):?>
                <li><a href="#h2">Регламент техобслуживания <?= $modelName;?></a></li>
	        <?php endif;?>
            <?php if ($categoryParams->module_2):?>
                <li><a href="#h3">Почему клиенты выбирают нас</a></li>
	        <?php endif;?>
	        <?php if ($categoryParams->module_3 || $categoryParams->module_4):?>
                <li><a href="#h4">Где пройти техобслуживание <?= $modelName;?></a></li>
	        <?php endif;?>
	        <?php if ($categoryParams->module_5):?>
                <li><a href="#h5">Гарантийные обязательства</a></li>
	        <?php endif;?>
        </ul>
        <p>
            Наш автосервис осуществляет качественное послегарантийное техобслуживание <?= $modelName;?>. Будьте уверены,
            что Ваша машина в надежных руках, поскольку наши профессиональные автомеханики имеют многолетний опыт работы и
            производят сервисное обслуживание в соответствии с официальным регламентом автопроизводителя.
        </p>
        <button type="button" class="uk-width-1-1 uk-button uk-button-success uk-button-large uk-margin-top contactus-<?= $categoryParams->module_6;?>">
            Записаться на техобслуживание <?= $modelName;?>
        </button>
    </div>
</div>
<hr class="uk-article-divider">
<!-- h1 - Сколько стоит техобслуживание -->
<div id="h1">
    <div class="uk-panel uk-panel-box uk-margin-large-top">
        <h2 class="uk-text-center">
            Стоимость технического обслуживания <?= $modelName;?>
            <a class="tm-totop-scroller" title="вернуться к оглавлению" href="#" data-uk-smooth-scroll=""></a>
        </h2>
        <p class="uk-text-center uk-text-danger uk-text-bold">
            Выберите год выпуска автомобиля. Кликните на иконку, соответствующую Вашему типу мотора и пробегу.<br>Узнайте полную информацию о перечне и стоимости регламентных работ и рекомендуемых запчастей.
        </p>
    </div>
    <div class="uk-accordion uk-margin-top" data-uk-accordion="{showfirst:false}">
        <?php foreach ($config as $years => $motors):?>
<!--            <div class="uk-panel uk-panel-box uk-margin-top">-->
                <h3 class="uk-accordion-title"><i class="uk-icon-angle-double-down uk-text-danger uk-margin-right"></i><?= $years;?></h3>
<!--            </div>-->
            <div class="uk-accordion-content">
                <div class="uk-overflow-container">
                    <table class="uk-table ls-table-condensed">
                        <thead>
                            <?php if ($motors['type'] == 'benzin') {
                                thead_tr_benzin();
                            }
                            elseif ($motors['type'] == 'dizel') {
                                thead_tr_dizel();
                            }
                            ?>
                        </thead>
                        <tbody>
                            <?php foreach ($motors['motors'] as $key => $motor):
                                tbody_tr($motor);
                            endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<!-- h2 - Регламент техобслуживания -->
<?php if ($categoryParams->module_1):?>
    <div id="h2">
        <div class="uk-panel uk-panel-box uk-margin-large-top">
            <h2 class="uk-text-center">
                Регламент техобслуживания <?= $modelName;?>
                <a class="tm-totop-scroller" title="вернуться к оглавлению" href="#" data-uk-smooth-scroll=""></a>
            </h2>
        </div>
        <p>
            Регулярное техническое обслуживание автомобиля <?= $modelName;?>- это определяемый производителем список сервисных работ, выполняемых один раз в год или каждые 15 000 километров.
        </p>
        <div class="uk-margin-top">{module <?= $categoryParams->module_1;?>}</div>
    </div>
<?php endif;?>

<!-- h3 - Почему клиенты выбирают нас -->
<?php if ($categoryParams->module_2):?>
    <div id="h3">
        <div class="uk-panel uk-panel-box uk-margin-large-top">
            <h2 class="uk-text-center">
                Пройдите ТО в наших автосервисах и получите
                <a class="tm-totop-scroller" title="вернуться к оглавлению" href="#" data-uk-smooth-scroll=""></a>
            </h2>
        </div>
        <div class="uk-margin-top">{module <?= $categoryParams->module_2;?>}</div>
    </div>
<?php endif;?>
<!-- h4 - Где пройти техобслуживание -->
<?php if ($categoryParams->module_3 || $categoryParams->module_4):?>
    <div id="h4">
        <div class="uk-panel uk-panel-box uk-margin-large-top">
            <h2 class="uk-text-center">
                Где пройти техобслуживание <?= $modelName;?>
                <a class="tm-totop-scroller" title="вернуться к оглавлению" href="#" data-uk-smooth-scroll=""></a>
            </h2>
        </div>
        <div class="uk-margin-top">{module <?= $categoryParams->module_3;?>}</div>
        <div class="uk-margin-top">{module <?= $categoryParams->module_4;?>}</div>
    </div>
<?php endif;?>
<!-- h5 - Гарантийные обязательства -->
<?php if ($categoryParams->module_5):?>
    <div id="h5">
        <div class="uk-panel uk-panel-box uk-margin-large-top">
            <h2 class="uk-text-center">
                Гарантийные обязательства
                <a class="tm-totop-scroller" title="вернуться к оглавлению" href="#" data-uk-smooth-scroll=""></a>
            </h2>
        </div>
        <div class="uk-margin-top">{module <?= $categoryParams->module_5;?>}</div>
    </div>
<?php endif;?>
<!-- h6 - Записаться на ТО -->
<?php if ($categoryParams->module_6 && $categoryParams->module_7):?>
    <div id="h6">
        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-2">
                <hr class="uk-article-divider">
                <div class="uk-panel uk-panel-box">
                    <h2 class="uk-text-center">
                        Записаться на техническое обслуживание
                    </h2>
                </div>
                <div class="uk-text-center uk-margin-top">
                    {module <?= $categoryParams->module_8;?>}
                </div>
            </div>
            <div class="uk-width-medium-1-2">
                <hr class="uk-article-divider">
                <div class="uk-panel uk-panel-box">
                    <h2 class="uk-text-center">
                        Обсудить или задать вопрос
                    </h2>
                </div>
                <div class="uk-text-center uk-margin-top">
                    {module <?= $categoryParams->module_7;?>}
                </div>
                <div class="uk-margin-top">
                    <!-- Ссылки -->
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

<div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-large-top">
    <p class="uk-h4 uk-text-warning">Напоминаем, что своевременное проведение технического обслуживания <?= $modelName;?> в специализированном сервисе с применением качественных
        расходных материалов увеличивает срок эксплуатации автомобиля до ремонта.
    </p>
</div>

<?php if (in_array(3, $this->user->getAuthorisedViewLevels())) { ?>
    <!-- Панель фильтров -->
    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-top uk-margin-bottom">
        <form class="uk-form" method="post" action="<?= $this->action; ?>" name="adminForm"
              id="adminForm" enctype="multipart/form-data">
            <!-- Вывод фильтров -->
            <fieldset data-uk-margin>
	            <?= isset($this->filters[MaintenanceKeys::KEY_MODEL]) ? $this->filters[MaintenanceKeys::KEY_MODEL]->onRenderFilter($this->section) : ''; ?>
	            <?= isset($this->filters[MaintenanceKeys::KEY_YEAR]) ? $this->filters[MaintenanceKeys::KEY_YEAR]->onRenderFilter($this->section) : ''; ?>
	            <?= isset($this->filters[MaintenanceKeys::KEY_MOTOR]) ? $this->filters[MaintenanceKeys::KEY_MOTOR]->onRenderFilter($this->section) : ''; ?>
	            <?= isset($this->filters[MaintenanceKeys::KEY_MILEAGE]) ? $this->filters[MaintenanceKeys::KEY_MILEAGE]->onRenderFilter($this->section) : ''; ?>
                <button class="uk-button" type="button" title="Применить выбранные фильтры"
                    onclick="Joomla.submitbutton('records.filters')">Поиск
                </button>
            </fieldset>
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
    </div>
    <!-- Конец панели фильтров -->

    <!-- Панель меню -->
    <div class="uk-navbar uk-margin-top">
        <div class="uk-navbar-nav">
            <!-- Вывод состояния фильтров -->
            <?php if ($this->worns): ?>
                <?= JLayoutHelper::render('b0.filterStatus', ['worns' => $this->worns,]);?>
            <?php endif; ?>
        </div>
        <div class="uk-navbar-flip">
            <ul class="uk-subnav uk-subnav-line">
                <!-- Добавить запись -->
                <?php if(!empty($this->postbuttons)) :
                    echo JLayoutHelper::render('b0.addItem', [
                        'postButtons' => $this->postbuttons,
                        'section' => $this->section,
                        'category' => $this->category,
                        'typeName' => 'Техобслуживание'
                    ]);
                endif; ?>
            </ul>
        </div>
    </div>
    <!-- Конец панели меню -->

    <!-- Вывод статей -->
    <?php if($this->items):?>
        <?= $this->loadTemplate('list_'.$this->list_template);?>

        <?php if ($this->tmpl_params['list']->def('tmpl_core.item_pagination', 1)) : ?>
            <form method="post">
                <div style="text-align: center;">
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
                    <div style="text-align: center;" class="pagination">
                        <?= str_replace('<ul>', '<ul class="pagination-list">', $this->pagination->getPagesLinks()); ?>
                    </div>
                    <div class="clearfix"></div>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    <?php elseif($this->worns):?>
        <h4 align="center">По Вашему запросу ничего не найдено</h4>
    <?php endif;?>
<?php }?>

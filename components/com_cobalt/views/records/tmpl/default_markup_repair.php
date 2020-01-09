<?php
defined('_JEXEC') or die('Restricted access');

$user_id = $this->input->getInt('user_id', 0);
$app = JFactory::getApplication();

$markup = $this->tmpl_params['markup'];
$listparams = $this->tmpl_params['list'];

// Параметры сортировки
$listOrder	= @$this->ordering;
$listDirn	= @$this->ordering_dir;

$back = NULL;
if($this->input->getString('return'))
{
	$back = Url::get_back('return');
}

$isMe = $this->isMe;
//$current_user = JFactory::getUser($this->input->getInt('user_id', $this->user->get('id')));

//Ключи фильтров
//$filter_key_category = 'k08005f0bec31df8ff08571ea0c969280';
$filter_key_model = 'k2c2d3a150ee055e8a427be13d2db1eb5';
//$filter_key_year = 'k188db5d9655bc4fcbb8bd1365184885e';
$filter_key_motor = 'kdc66b066adb35de6d0e8f7a34554230e';
$filter_key_drive = 'k608a63da4652b340b1e8df15b38c955d';

$this->document->setTitle($this->description . ' в Логан-Сервис СПб');
?>

<!--  Шапка раздела -->
<div class="uk-grid" data-uk-grid-margin>
    <!-- Иконка раздела -->
    <div class="uk-width-small-1-6">
		<?php if ($this->category->id) { ?>
            <img src="/<?= $this->category->image; ?>" width="135" height="135" alt="<?= $this->description; ?>">
        <?php }
		else { ?>
            <img src="/<?= $markup['main']->section_icon; ?>" width="135" height="135" alt="<?= $this->description; ?>">
		<?php } ?>
    </div>

    <div class="uk-width-small-5-6">
        <div class="uk-grid" data-uk-grid-margin>
            <!-- Заголовок раздела -->
            <div class="uk-width-small-1-1">
				<?php
				if ($this->category->level > 1) {
					$tmp = explode('/', $this->category->crumbs);
					$title = $this->title . ' ' . trim($tmp[1]);
				}
				else {
					$title= $this->title;
				}
				?>

                <h1>
					<?= $this->escape($title); ?>
                </h1>
            </div>
            <!-- Описание раздела -->
            <div class="uk-width-medium-1-1 uk-hidden-small">
                <hr class="uk-article-divider">
                <p class="ls-sub-title">
					<?php if($this->description) echo $this->description; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<hr class="uk-article-divider">

<!-- Панель фильтров -->
<?php if (!$this->category->id) {?>
    <div class="uk-panel uk-panel-box uk-panel-box-secondary" data-uk-grid-margin>
        <form class="uk-form" method="post" action="<?= $this->action; ?>" name="adminForm"
              id="adminForm" enctype="multipart/form-data">
            <!-- Вывод фильтров -->
            <fieldset data-uk-margin>
                Я ищу
                <input id="form-h-it" class="uk-form uk-form-width-medium" placeholder="Все работы" name="filter_search"
                       value="<?= htmlentities($this->state->get('records.search'), ENT_COMPAT, 'utf-8'); ?>"/>
                для
				<?= $this->filters[$filter_key_model]->onRenderFilter($this->section); ?>
				<?= $this->filters[$filter_key_motor]->onRenderFilter($this->section); ?>
				<?= $this->filters[$filter_key_drive]->onRenderFilter($this->section); ?>
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
<?php }?>
<!-- Конец панели фильтров -->

<!-- Статус фильтров -->
<?php if ($this->worns): ?>
    <div class="uk-panel uk-panel-box uk-width-1-1" data-uk-sticky>
        <?php if (count($this->worns) > 1) : ?>
            <button class="uk-button uk-button-link uk-float-right" type="button"
                    title="Сбросить все примененные фильтры"
                    onclick="Joomla.submitbutton('records.cleanall')">
                <img src="<?= JURI::root(TRUE) ?>/media/mint/icons/16/cross-button.png" align="absmiddle"
                     alt="<?= JText::_('CRESETFILTERS'); ?>"/>
                <?= JText::_('CRESETFILTERS'); ?></button>
        <?php endif; ?>

        <dl class="uk-description-list">
            <dt class="uk-text-danger">Установленные фильтры</dt>
            <dd>
                <?php foreach ($this->worns as $worn): ?>
                    <strong><?= $worn->label . ": " ?></strong>
                    <?= $worn->text ?>
                    <button type="button" class="uk-button-link"
                            onclick="Cobalt.cleanFilter('<?= $worn->name ?>')"
                            data-uk-tooltip title="<?= JText::_('CDELETEFILTER') . '<br>' . $worn->label ?>">
                        <i class="uk-icon-close"></i>
                    </button>
                <?php endforeach; ?>
            </dd>
        </dl>
    </div>
<?php endif; ?>
<!-- Конец статуса фильтров -->

<!-- Панель меню -->
<?php if($markup->get('menu.menu')):?>
    <nav class="uk-navbar uk-margin">
        <ul class="uk-subnav uk-subnav-line uk-float-right">
            <!-- Прайс-лист -->
	        <?php if ($this->category->id AND in_array('3', $this->user->getAuthorisedViewLevels())): ?>
                <li class="uk-hidden-small">
                    <a href="/pricelist-works.xlsx"  title="Скачать прайс-лист в формате Excel" download>
                        <i class="uk-icon-file-excel-o uk-icon-small uk-margin-right"></i>
                        Прайс-лист
                    </a>
                </li>
	        <?php endif; ?>

            <!-- Добавить запись -->
	        <?php if(!empty($this->postbuttons)) {
		        $submit = array_values($this->postbuttons);
		        $submit = array_shift($submit);
		        ?>
                <li class="dropdown">
                    <a
				        <?php if(!(in_array($submit->params->get('submission.submission'),  $this->user->getAuthorisedViewLevels()) || MECAccess::allowNew($submit, $this->section))): ?>
                            class="disabled tip-bottom" rel="tooltip" href="#"
                            data-original-title="<?= JText::sprintf($markup->get('menu.menu_user_register', 'Register or login to submit <b>%s</b>'), JText::_($submit->name))?>"
				        <?php else:?>
                            href="<?= Url::add($this->section, $submit, $this->category);?>"
				        <?php endif;?>
                    >
				        <?php if($markup->get('menu.menu_newrecord_icon')):?>
					        <?= HTMLFormatHelper::icon('plus.png');  ?>
				        <?php endif;?>
				        <?= JText::sprintf($markup->get('menu.menu_user_single', 'Post %s here'), JText::_($submit->name));?>
                    </a>
                </li>
	        <?php } ?>

            <!-- Сортировка -->
            <?php if (in_array($markup->get('menu.menu_ordering'), $this->user->getAuthorisedViewLevels()) && $this->items) {?>
                <li data-uk-dropdown="{mode:'click'}">
                    <a href="#">
                        <?php if ($markup->get('menu.menu_ordering_icon')): ?>
                            <?= HTMLFormatHelper::icon('sort.png'); ?>
                        <?php endif; ?>
                        <?= JText::_($markup->get('menu.menu_ordering_label', 'Sort By'))?>
                        <i class="uk-icon-caret-down"></i>
                    </a>
                    <div class="uk-dropdown uk-panel uk-panel-box uk-panel-box-secondary">
                        <ul class="uk-nav uk-nav-dropdown">

                            <!-- По релевантности поиска -->
                            <?php if (@$this->items[0]->searchresult): ?>
                                <li>
                                    <?= JHtml::_('mrelements.sort', ($markup->get('menu.menu_order_ctime_icon') ? HTMLFormatHelper::icon('document-search-result.png') : null) .
                                        ' ' . JText::_('CORDERRELEVANCE'), 'searchresult', $listDirn, $listOrder); ?>
                                </li>
                            <?php endif; ?>

                            <!-- По наименованию -->
                            <?php if (in_array($markup->get('menu.menu_order_title'), $this->user->getAuthorisedViewLevels())): ?>
                                <li>
                                    <?= JHtml::_('mrelements.sort', ($markup->get('menu.menu_order_title_icon') ? HTMLFormatHelper::icon('edit.png') : null) .
                                        ' ' . JText::_($markup->get('menu.menu_order_title_label', 'Title')), 'r.title', $listDirn, $listOrder); ?>
                                </li>
                            <?php endif; ?>

                            <!-- По количеству просмотров -->
                            <?php if (in_array($markup->get('menu.menu_order_hits'), $this->user->getAuthorisedViewLevels())): ?>
                                <li>
                                    <?= JHtml::_('mrelements.sort', ($markup->get('menu.menu_order_hits_icon') ? HTMLFormatHelper::icon('hand-point-090.png') : null) . ' ' . JText::_($markup->get('menu.menu_order_hits_label', 'Hist')), 'r.hits', $listDirn, $listOrder); ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php }?>
        </ul>
    </nav>
<?php endif;?>
<!-- Конец панели меню -->

<!-- Вывод индекса категории -->
<?php if (!$this->worns) {?>
	<?= $this->loadTemplate('cindex_'.$this->section->params->get('general.tmpl_category'));?>
<?php }?>

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
<!--	<h4 align="center">--><?//= JText::_('CNORECFOUNDSEARCH');?><!--</h4>-->
	<p class="uk-h4 uk-text-center">По Вашему запросу ничего не обнаружено</p>
<?php endif;?>

<script>
    "use strict";
    let motorsArray = {
        "Logan"                 : ["K7J (1.4 8V)", "K7M (1.6 8V)", "K4M (1.6 16V)"],
        "Sandero"               : ["K7J (1.4 8V)", "K7M (1.6 8V)", "K4M (1.6 16V)"],
        "Duster"                : ["K4M (1.6 16V)","F4R (2.0 16V)","H4M (1.6 16V)", "K9K (1.5 8V dci)"],
        "Kaptur"                : ["F4R (2.0 16V)","H4M (1.6 16V)"],
        "Dokker"                : ["K7M (1.6 8V)","K9K (1.5 8V dci)"]
    };

    let drivesArray = {
        "Logan"                       : [],
        "Sandero"                     : [],
        "Duster"                      : ["2WD","4WD"],
        "Kaptur"                      : ["2WD","4WD"],
        "Dokker"                      : []
    };

    //Обработчик события изменения выбора модели
    (function ($) {
        $('#filtersk2c2d3a150ee055e8a427be13d2db1eb5value')
            .change(function () {
                setMotors();
                setDrives();
            })
            .change();
    })(jQuery);

    //Установка списка моторов
    function setMotors() {
        let modelName = jQuery('#filtersk2c2d3a150ee055e8a427be13d2db1eb5value').val();
        let modelInFilter = '<?= isset($this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']) ? $this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']->text : ''; ?>';
        let motorSet = jQuery('#filterskdc66b066adb35de6d0e8f7a34554230evalue');
        if (!modelName) {
            motorSet.val("");
            motorSet.attr("title", "Предварительно необходимо выбрать модель");
            motorSet.attr("disabled", true);
        }
        else {
            let optionsList = motorSet.children(':gt(0)');
            //Открываем весь список моторов
            optionsList.each(function () {
                jQuery(this).attr("hidden", false);
            });
            optionsList.each(function () {
                let option = jQuery(this).attr('value');
                if (!inArray(option, motorsArray[modelName])) {
                    jQuery(this).attr("hidden", true);
                }
            });
            if (modelName != modelInFilter) {
                motorSet.val("");
            }
            motorSet.attr("title", "При желании Вы можете выбрать мотор для " + modelName);
            motorSet.attr("disabled", false);
        }
    }

    //Установка списка приводов
    function setDrives() {
        let modelName = jQuery('#filtersk2c2d3a150ee055e8a427be13d2db1eb5value').val();
        let modelInFilter = '<?= isset($this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']) ? $this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']->text : ''; ?>';
        let driveSet = jQuery('#filtersk608a63da4652b340b1e8df15b38c955dvalue');
        let optionsList = driveSet.children(':gt(0)');
        //console.log(drivesArray[modelName]);
        if (!modelName) {
            driveSet.val("");
            driveSet.attr("title", "Предварительно необходимо выбрать модель");
            driveSet.attr("disabled", true);
        }
        else if (drivesArray[modelName].length === 0 ) {
            //driveSet.val("");
            driveSet.attr("title", "У модели " + modelName + " нет вариантов");
            driveSet.attr("disabled", true);
        }
        else {
            //let optionsList = driveSet.children(':gt(0)');
            //Открываем весь список модификаций
            optionsList.each(function () {
                jQuery(this).attr("hidden", false);
            });
            optionsList.each(function () {
                let option = jQuery(this).attr('value');
                if (!inArray(option, drivesArray[modelName])) {
                    jQuery(this).attr("hidden", true);
                }
            });
            //console.log(optionsList.length);
/*
            if (optionsList.length === 0) {  //TODO изменить условие
                driveSet.attr("disabled", true);
            }
            else {
*/
                if (modelName !== modelInFilter) {
                    driveSet.val("");
                }
                driveSet.attr("title", "При желании Вы можете выбрать привод для " + modelName);
                driveSet.attr("disabled", false);
//            }
        }
    }

    function inArray(what, where) {
        for (let i = 0; i < where.length; i++)
            if (what === where[i]) {
                return true;
            }
        return false;
    }
</script>
<?php
defined('_JEXEC') or die('Restricted access');
JImport('b0.Sparepart.SparepartKeys');
JImport('b0.fixtures');

$user_id = $this->input->getInt('user_id', 0);
$app = JFactory::getApplication();

$markup = $this->tmpl_params['markup'];
$params = $this->tmpl_params['markup'];
$listparams = $this->tmpl_params['list'];
$user_name = CCommunityHelper::getName($user_id, $this->section, array('nohtml' => 1));
// Параметры сортировки
$listOrder	= @$this->ordering;
$listDirn	= @$this->ordering_dir;

/*$back = NULL;
if($this->input->getString('return'))
{
	$back = Url::get_back('return');
}*/

//$isMe = $this->isMe;
//$view_what = $this->input->get('view_what');
//$current_user = JFactory::getUser($this->input->getInt('user_id', $this->user->get('id')));
//$counts = $this->_getUsermenuCounts($markup);

//Ключи фильтров
//$filter_key_category = 'k08005f0bec31df8ff08571ea0c969280';
//$filter_key_model = 'k5331be4bd2bab68c64bbcaa490bcaede';
//$filter_key_year = 'k188db5d9655bc4fcbb8bd1365184885e';
//$filter_key_motor = 'k6fb54fcb62a9a7e9e08cbc52b423cb21';
//$filter_key_modification = 'k6f262505ad26607d73135973a916588d';

$filterKeyModel = '#filters'. SparepartKeys::KEY_MODEL .'value';
$filterKeyYear = '#filters'. SparepartKeys::KEY_YEAR .'value';
$filterKeyMotor = '#filters'. SparepartKeys::KEY_MOTOR .'value';
$filterKeyDrive = '#filters'. SparepartKeys::KEY_DRIVE .'value';

$pre_filter_model = 'index.php?option=com_cobalt&task=records.filter&section_id=2&Itemid=108&filter_name[0]=filter_k5331be4bd2bab68c64bbcaa490bcaede&filter_val[0]=';
$pre_filter_category = 'index.php?option=com_cobalt&task=records.filter&section_id=2&Itemid=108&filter_name[0]=filter_k08005f0bec31df8ff08571ea0c969280&filter_val[0]=';
?>

<!--  Шапка раздела -->
<div class="uk-grid" data-uk-grid-margin>
    <!-- Иконка раздела -->
    <div class="uk-width-1-6">
        <img src="/images/icons-section/icon-catalog.png" width="120" height="90" alt="<?= $this->description; ?>">
    </div>

    <div class="uk-width-5-6">
        <div class="uk-grid" data-uk-grid-margin>
            <!-- Заголовок раздела -->
            <div class="uk-width-1-1">
                <h1>
                    <?= $this->title; ?>
                </h1>
            </div>
            <!-- Описание раздела -->
            <div class="uk-width-1-1 uk-hidden-small">
                <hr class="uk-article-divider">
                <p class="ls-sub-title">
                    <?php if ($this->section->description) echo $this->section->description; ?>
                </p>
            </div>
        </div>
    </div>
</div>
<hr class="uk-article-divider">
<!-- Панель фильтров -->
<div class="uk-panel uk-panel-box uk-panel-box-secondary uk-width-1-1" data-uk-grid-margin>
    <form class="uk-form uk-form-horizontal" method="post" action="<?= $this->action; ?>" name="adminForm"
          id="adminForm" enctype="multipart/form-data">
        <!-- Вывод фильтров -->
        <div class="uk-form-row">
            <label class="uk-form-label" style="width: 100px" for="form-h-it">Я ищу</label>
            <input type="text" id="form-h-it" class="uk-form-large uk-form-width-large uk-form-danger"
                   placeholder="Введите название или код запчасти" name="filter_search"
                   value="<?= htmlentities($this->state->get('records.search'), ENT_COMPAT, 'utf-8'); ?>"/>
            <?= $this->filters[SparepartKeys::KEY_CATEGORY]->onRenderFilter($this->section); ?>
            <button class="uk-button uk-button-large" type="button" title="Применить выбранные фильтры"
                    onclick="Joomla.submitbutton('records.filters')">Поиск
            </button>
        </div>
        <div class="uk-form-row">
            <label class="uk-form-label" style="width: 100px" for="form-2-it">Для</label>
            <div id="form-2-it" class="uk-form-controls uk-form-controls-text" style="margin-left: 100px">
                <?= $this->filters[SparepartKeys::KEY_MODEL]->onRenderFilter($this->section); ?>
                <?= $this->filters[SparepartKeys::KEY_YEAR]->onRenderFilter($this->section); ?>
                <?= $this->filters[SparepartKeys::KEY_MOTOR]->onRenderFilter($this->section); ?>
                <?= $this->filters[SparepartKeys::KEY_DRIVE]->onRenderFilter($this->section); ?>
            </div>
        </div>
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

<!-- Префильтры по моделям и категориям -->
<?php if(!$this->worns):?>
    <div class="accordion uk-margin-top" id="prefilters">
        <div class="accordion-group">
            <div class="uk-h3 accordion-heading">
                <a rel="nofollow" href="#models" class="accordion-toggle uk-text-danger"
                   data-toggle="collapse" data-parent="#prefilters" title="Быстрый отбор по модели авто">
                    <i class="uk-icon-car uk-margin-right"></i>Быстрый выбор модели
                </a>
            </div>
            <div id="models" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul class="uk-grid uk-text-center" data-uk-grid-margin>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Logan');?>"
                                    title="Запчасти и аксессуары для Renault Logan">
                                    <img src="/images/icons-cars/icon-renault-logan.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Logan">
                                    <p>Logan</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Logan II');?>"
                                   title="Запчасти и аксессуары для Renault Logan 2">
                                    <img src="/images/icons-cars/icon-renault-logan-ii.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Logan 2">
                                    <p>Logan 2</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Sandero');?>"
                                   title="Запчасти и аксессуары для Renault Sandero">
                                    <img src="/images/icons-cars/icon-renault-sandero.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Sandero">
                                    <p>Sandero</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Sandero II');?>"
                                   title="Запчасти и аксессуары для Renault Sandero 2">
                                    <img src="/images/icons-cars/icon-renault-sandero-ii.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Sandero 2">
                                    <p>Sandero 2</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Sandero Stepway');?>"
                                   title="Запчасти и аксессуары для Renault Sandero Stepway">
                                    <img src="/images/icons-cars/icon-renault-sandero-stepway.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Sandero Stepway">
                                    <p>Sandero Stepway</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Sandero Stepway II');?>"
                                   title="Запчасти и аксессуары для Renault Sandero Stepway 2">
                                    <img src="/images/icons-cars/icon-renault-sandero-stepway-ii.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Sandero Stepway 2">
                                    <p>Sandero Stepway 2</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Duster');?>"
                                   title="Запчасти и аксессуары для Renault Duster">
                                    <img src="/images/icons-cars/icon-renault-duster.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Duster">
                                    <p>Duster</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Duster II');?>"
                                   title="Запчасти и аксессуары для Renault Duster 2">
                                    <img src="/images/icons-cars/icon-renault-duster-ii.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Duster 2">
                                    <p>Duster 2</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Kaptur');?>"
                                   title="Запчасти и аксессуары для Renault Kaptur">
                                    <img src="/images/icons-cars/icon-renault-kaptur.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Kaptur">
                                    <p>Kaptur</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-5">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_model, 'Dokker');?>"
                                   title="Запчасти и аксессуары для Renault Dokker">
                                    <img src="/images/icons-cars/icon-renault-dokker.png" width="175" height="80"
                                         alt="Запчасти и аксессуары для Renault Dokker">
                                    <p>Dokker</p>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="uk-h3 accordion-heading">
                <a rel="nofollow" href="#categories" class="accordion-toggle uk-text-danger"
                    data-toggle="collapse" data-parent="#prefilters" title="Быстрый отбор по категории запчасти">
                    <i class="uk-icon-book uk-margin-right"></i>Быстрый выбор категории
                </a>
            </div>
            <div id="categories" class="accordion-body collapse">
                <div class="accordion-inner">
                    <ul class="uk-grid uk-text-center" data-uk-grid-margin>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Двигатель');?>"
                                   title="Запчасти двигателя для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-engine.png" width="135" height="135"
                                         alt="Запчасти двигателя для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Двигатель</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Рулевое');?>"
                                   title="Запчасти рулевого управления для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-steering.png" width="135" height="135"
                                         alt="Запчасти рулевого управления для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Рулевое</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Ходовая');?>"
                                   title="Запчасти ходовой для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-run.png" width="135" height="135"
                                         alt="Запчасти ходовой для Renault Logan, Renault Sandero, Renault Duster и Renault Kapturr">
                                    <p>Ходовая</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Трансмиссия');?>"
                                   title="Запчасти трансмиссии для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-transmission.png" width="135" height="135"
                                         alt="Запчасти трансмиссии для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Трансмиссия</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Тормоза');?>"
                                   title="Запчасти тормозной системы для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-braking.png" width="135" height="135"
                                         alt="Запчасти тормозной системы для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Тормоза</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Кузов');?>"
                                   title="Запчасти кузова для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-body.png" width="135" height="135"
                                         alt="Запчасти кузова для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Кузов</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Салон');?>"
                                   title="Запчасти салона для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-salon.png" width="135" height="135"
                                         alt="Запчасти салона для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Салон</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Электрика');?>"
                                   title="Запчасти электрики для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-ignition.png" width="135" height="135"
                                         alt="Запчасти электрики для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Электрика</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Масла');?>"
                                   title="Масла для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-oil.png" width="135" height="135"
                                         alt="Масла для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Масла</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Фильтры');?>"
                                   title="Фильтры для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-filters.png" width="135" height="135"
                                         alt="Фильтры для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Фильтры</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Лампы');?>"
                                   title="Автомобильные лампы для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-lamps.png" width="135" height="135"
                                         alt="Автомобильные лампы для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Лампы</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Диски');?>"
                                   title="Диски колесные для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                <img src="/images/icons-category/icon-disc.png" width="135" height="135"
                                     alt="Диски колесные для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                <p>Диски</p>
                            </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Крепеж');?>"
                                   title="Крепеж для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-fixtures.png" width="135" height="135"
                                         alt="Крепеж для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Крепеж</p>
                                </a>
                            </div>
                        </li>
                        <li class="uk-width-medium-1-6">
                            <div class="uk-h4">
                                <a rel="nofollow" href="<?php create_href($pre_filter_category, 'Прочее');?>"
                                   title="Прочие запчасти для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <img src="/images/icons-category/icon-other-assesories.png" width="135" height="135"
                                         alt="Прочие запчасти для Renault Logan, Renault Sandero, Renault Duster и Renault Kaptur">
                                    <p>Прочее</p>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="accordion-group">
            <div class="uk-h3 accordion-heading">
                <a rel="nofollow" href="#alphabet" class="accordion-toggle uk-text-danger"
                   data-toggle="collapse" data-parent="#prefilters" title="Быстрый отбор по категории запчасти">
                    <i class="uk-icon-sort-alpha-asc uk-margin-right"></i>Запчасти по алфавиту
                </a>
            </div>
            <div id="alphabet" class="accordion-body collapse">
                <div class="accordion-inner">
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

                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<!-- Конец префильтров по моделям и категориям -->

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
	            <?php if (in_array('3', $this->user->getAuthorisedViewLevels())): ?>
                    <li class="uk-hidden-small">
                        <a href="/pricelist-spareparts.xlsx"  title="Скачать прайс-лист в формате Excel" download>
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
                        'typeName' => 'Запчасть'
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
										<?= JHtml::_('mrelements.sort',  'Цене', 'field^'.SparepartKeys::KEY_PRICE_GENERAL.'^digits', $listDirn, $listOrder); ?>
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

<!-- Вывод статей -->
<?php if($this->items) {
	echo $this->loadTemplate('list_'.$this->list_template);
}
elseif($this->worns) {
    echo '<h4 align="center">К сожалению, по Вашему запросу ничего не найдено. Попробуйте:</h4>';
    if (isset($this->worns['search'])) {
        echo '<h4 align="center">- изменить поисковую фразу</h4>';
    }
    if (isset($this->worns[SparepartKeys::KEY_CATEGORY])) {
        echo '<h4 align="center">- изменить выбранную категорию</h4>';
    }
} ?>

<?php
/**
 * @param string $pre_filter
 * @param string $model
 */
function create_href($pre_filter, $model) {
	echo $pre_filter.urlencode($model);
}
?>

<script src="/layouts/logan_shop/js/catalog_filter_data.js"></script>

<script>
//Обработчик события изменения выбора модели
(function ($) {
    $('<?= $filterKeyModel;?>')
        .change(function () {
        let modelName = $(this).val();
            setYears();
            setMotors();
            setModifications();
        })
        .change();
})(jQuery);

//Установка списка годов выпуска
function setYears() {
    let modelName = jQuery('<?= $filterKeyModel;?>').val();
    let modelInFilter = '<?= $this->worns[SparepartKeys::KEY_MODEL]->text ?? ''; ?>';
    let yearSet = jQuery('<?= $filterKeyYear;?>');

    if (!modelName) {   //Модель не выбрана
        yearSet.val("");
        yearSet.attr("title", "Предварительно необходимо выбрать модель");
        yearSet.attr("disabled", true);
    }
    else {                          //Модель выбрана
        let optionsList = yearSet.children(':gt(0)');
        //Сначала открываем весь список годов выпуска
        optionsList.each(function () {
            jQuery(this).attr("hidden", false);
        });
        //Потом устанавливаем года выпуска соответственно установленной модели
        optionsList.each(function () {
            let option = jQuery(this).attr('value');
            if (!inArray(option, yearsArray[modelName])) {
                jQuery(this).attr("hidden", true);
            }
        });
        if (modelName !== modelInFilter) {
            yearSet.val("");
        }
        yearSet.attr("title", "При желании Вы можете выбрать год выпуска для " + modelName);
        yearSet.attr("disabled", false);
    }
}

//Установка списка моторов
function setMotors() {
    let modelName = jQuery('<?= $filterKeyModel;?>').val();
    let modelInFilter = '<?= $this->worns[SparepartKeys::KEY_MODEL]->text ?? ''; ?>';
    let motorSet = jQuery('<?= $filterKeyMotor;?>');
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
        if (modelName !== modelInFilter) {
            motorSet.val("");
        }
        motorSet.attr("title", "При желании Вы можете выбрать мотор для " + modelName);
        motorSet.attr("disabled", false);
    }
}

//Установка списка модификаций
function setModifications() {
    let modelName = jQuery('<?= $filterKeyModel;?>').val();
    let modelInFilter = '<?= $this->worns[SparepartKeys::KEY_MODEL]->text ?? ''; ?>';
    let modificationSet = jQuery('<?= $filterKeyDrive;?>');
    if (!modelName) {
        modificationSet.val("");
        modificationSet.attr("title", "Предварительно необходимо выбрать модель");
        modificationSet.attr("disabled", true);
    }
    else {
        let optionsList = modificationSet.children(':gt(0)');
        //Открываем весь список моторов
        optionsList.each(function () {
            jQuery(this).attr("hidden", false);
        });
        optionsList.each(function () {
            let option = jQuery(this).attr('value');
            if (!inArray(option, modificationsArray[modelName])) {
                jQuery(this).attr("hidden", true);
            }
        });
        if (optionsList.length === 0) {  //TODO изменить условие
            modificationSet.attr("disabled", true);
        }
        else {
            if (modelName !== modelInFilter) {
                modificationSet.val("");
            }
            modificationSet.attr("title", "При желании Вы можете выбрать модификацию для " + modelName);
            modificationSet.attr("disabled", false);
        }
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

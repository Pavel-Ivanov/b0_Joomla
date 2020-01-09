<?php
defined('_JEXEC') or die('Restricted access');
JImport('b0.fixtures');
JImport('b0.maintenancehelper');
$app = JFactory::getApplication();
$doc = JFactory::getDocument();

$markup     = $this->tmpl_params['markup'];
$listparams = $this->tmpl_params['list'];

// Параметры сортировки
$listOrder = @$this->ordering;
$listDirn  = @$this->ordering_dir;

$description = $this->category->metadesc;
$doc->setTitle($description . ' недорого в Логан-Шоп СПб');

$logan_2005_2009_k7jm = [
	'model'  => 'Renault Logan',
	'motor'  => '1.4/1.6 8V',
	'years'  => '2005-2009',
	'freq'   => 15000,
	'th'     => 'K7J (1.4 8V), K7M (1.6 8V)',
	'items'  => [
		[
			'milage' => 15000,
            'tdHref'   => '/maintenance/item/2877-1a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2873-2-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/2882-1b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2874-3-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/2883-1c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2875-4-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/2884-1d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2876-5-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign-grm'
		]
	]
];
$logan_2010_2011_k7jm = [
	'model'  => 'Renault Logan',
	'motor'  => '1.4/1.6 8V',
	'years'  => '2010-2011',
	'freq'   => 15000,
	'th'     => 'K7J (1.4 8V), K7M (1.6 8V)',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/2877-1a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2873-2-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/2882-1b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2885-6-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/2883-1c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2875-4-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/2884-1d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2886-7-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign-grm'
		]
	]
];
$logan_2010_2011_k4m = [
	'model'  => 'Renault Logan',
	'motor'  => '1.6 16V',
	'years'  => '2010-2011',
	'freq'   => 15000,
	'th'     => 'K4M (1.6 16V)',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/2872-13a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2902-14a-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/2887-13b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2942-15-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/2888-13c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2944-16-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/2889-13d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2943-17-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign-grm'
		]
	]
];
$logan_2012_2014_k7jm = [
	'model'  => 'Renault Logan',
	'motor'  => '1.4/1.6 8V',
	'years'  => '2012-2014',
	'freq'   => 15000,
	'th'     => 'K7J (1.4 8V), K7M (1.6 8V)',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/2896-8a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2890-9a-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/2895-8b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2897-10-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/2891-8c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2899-11-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/2892-8d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2901-12-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign-grm'
		]
	]
];
$logan_2012_2014_k4m = [
	'model'  => 'Renault Logan',
	'motor'  => '1.6 16V',
	'years'  => '2010-2011',
	'freq'   => 15000,
	'th'     => 'K4M (1.6 16V)',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/2872-13a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2902-14a-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/2887-13b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2942-15-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/2888-13c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2944-16-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/2889-13d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2943-17-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign-grm'
		]
	]
];
$logan_2015_k7m = [
	'model'  => 'Renault Logan',
	'motor'  => '1.6 8V',
	'years'  => 'с 2015',
	'freq'   => 15000,
	'th'     => 'K7M (1.6 8V)',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/5270-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/5271-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/5272-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2893-9b-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/5273-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2949-20-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-grm-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/5274-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2894-9c-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign'
		]
	]
];
$logan_2015_k4m = [
	'model'  => 'Renault Logan',
	'motor'  => '1.6 16V',
	'years'  => 'с 2015',
	'freq'   => 15000,
	'th'     => 'K4M (1.6 16V)',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/2872-13a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2903-14b-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/2887-13b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2904-14c-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/2888-13c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2950-19-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-grm-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/2889-13d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2905-14d-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign'
		]
	]
];
$logan_2015_h4m = [
	'model'  => 'Renault Logan',
	'motor'  => '1.6 16V',
	'years'  => 'с 2015',
	'freq'   => 15000,
	'th'     => 'H4M (1.6 16V)',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/5075-tekhobsluzhivanie-renault-logan-15000-km-to-1-h4m-1-6-16v-2016-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/5076-tekhobsluzhivanie-renault-logan-30000-km-to-2-h4m-1-6-16v-2016-2017',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/5077-tekhobsluzhivanie-renault-logan-45000-km-to-3-h4m-1-6-16v-2016-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/5078-tekhobsluzhivanie-renault-logan-60000-km-to-4-h4m-1-6-16v-2016-2017',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/5079-tekhobsluzhivanie-renault-logan-75000-km-to-5-h4m-1-6-16v-2016-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/5080-tekhobsluzhivanie-renault-logan-90000-km-to-6-h4m-1-6-16v-2016-2017',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/5081-tekhobsluzhivanie-renault-logan-105000-km-to-7-h4m-1-6-16v-2016-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/5082-tekhobsluzhivanie-renault-logan-120000-km-to-8-h4m-1-6-16v-2016-2017',
			'type'     => 'oil-ign'
		]
	]
];
?>

<!--  Шапка раздела -->
<div class="uk-grid data-uk-grid-margin">
    <!-- Иконка раздела -->
    <div class="uk-width-small-2-10">
        <img class="uk-align-center" src="/<?= $this->category->image; ?>" width="175" height="80"
             alt="<?= $this->description; ?>">
    </div>

    <div class="uk-width-small-4-10">
        <div class="uk-grid data-uk-grid-margin">
            <!-- Заголовок раздела -->
            <div class="uk-width-small-1-1">
                <h1>
					<?= $this->category->description; ?>
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

    <div class="uk-width-small-4-10">
        <div class="uk-panel uk-panel-box uk-panel-box-secondary">
            <ul class="uk-list">
                <li><a href="#price">Сколько стоит техобслуживание Renault Logan</a></li>
                <li><a href="#why">Почему клиенты выбирают нас</a></li>
                <li><a href="#where">Где пройти техобслуживание Renault Logan</a></li>
                <li><a href="#guarantee">Гарантийные обязательства</a></li>
            </ul>
        </div>
    </div>
</div>
<hr class="uk-article-divider">

<p>
    Регулярное техническое обслуживание автомобиля Рено Logan- это определяемый производителем список сервисных работ,
    выполняемых один раз в год или каждые 15 000 километров.
</p>
<p>
    Наш автосервис осуществляет качественное послегарантийное техобслуживание Рено Логан. Будьте уверены,
    что Ваша машина в надежных руках, поскольку наши профессиональные автомеханики имеют многолетний опыт работы и
    производят сервисное обслуживание в соответствии с официальным регламентом Renault.
</p>

<div class="uk-panel uk-panel-box uk-margin-large-top">
    <h2 id="price" class="uk-text-center">Стоимость технического обслуживания Renault Logan</h2>
    <p class="uk-text-center">
        Выберите год выпуска, тип мотора и пробег.<br>Узнайте полную информацию о перечне и стоимости регламентных работ
        и рекомендуемых запчастей.
    </p>
</div>

<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>2005 - 2009 года выпуска</h4>
</div>
<div class="uk-overflow-container">
    <table class="uk-table ls-table-condensed">
		<?php thead_benzin(); ?>
        <tbody>
            <?php tbody_tr($logan_2005_2009_k7jm);?>
        </tbody>
    </table>
</div>
<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>2010 - 2011 года выпуска</h4>
</div>
<div class="uk-overflow-container">
    <table class="uk-table ls-table-condensed">
		<?php thead_benzin(); ?>
        <tbody>
            <?php tbody_tr($logan_2010_2011_k7jm);?>
            <?php tbody_tr($logan_2010_2011_k4m);?>
        </tbody>
    </table>
</div>
<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>2012 - 2014 года выпуска</h4>
</div>
<div class="uk-overflow-container">
    <table class="uk-table ls-table-condensed">
		<?php thead_benzin(); ?>
        <tbody>
        <?php tbody_tr($logan_2012_2014_k7jm);?>
        <?php tbody_tr($logan_2012_2014_k4m);?>
        </tbody>
    </table>
</div>
<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>с 2015 года выпуска</h4>
</div>
<div class="uk-overflow-container">
    <table class="uk-table ls-table-condensed">
		<?php thead_benzin(); ?>
        <tbody>
        <!-- K7M (1.6 8V) -->
            <?php tbody_tr($logan_2015_k7m);?>
        <!-- K4M (1.6 16V) -->
            <?php tbody_tr($logan_2015_k4m);?>
        <!-- H4M (1.6 16V) -->
            <?php tbody_tr($logan_2015_h4m);?>
        </tbody>
    </table>
</div>

<div class="uk-panel uk-panel-box uk-margin-large-top uk-margin-bottom">
    <h2 id="why" class="uk-text-center">Почему клиенты выбирают нас</h2>
</div>
{module 159}

<div class="uk-panel uk-panel-box uk-margin-large-top uk-margin-bottom">
    <h2 id="where" class="uk-text-center">Где пройти техобслуживание Renault Logan</h2>
</div>
{module 158}
<div class="uk-margin-top">{module 143}</div>

<div class="uk-panel uk-panel-box uk-margin-large-top uk-margin-bottom">
    <h2 id="guarantee" class="uk-text-center">Гарантийные обязательства</h2>
</div>
{module 157}

<hr class="uk-article-divider">

<?php if (in_array(3, $this->user->getAuthorisedViewLevels())): ?>
    <!-- Панель фильтров -->
    <?php if (!$this->input->get('view_what')): ?>
        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-width-1-1" data-uk-grid-margin>
            <form class="uk-form uk-form-horizontal" method="post" action="<?= $this->action; ?>" name="adminForm"
                  id="adminForm" enctype="multipart/form-data">
                <!-- Вывод фильтров -->
                <div class="uk-form-row">
                    <div class="uk-form-controls uk-form-controls-text" style="margin-left: 10px">
                        <?php foreach ($this->filters as $filter)
                        {
                            echo $filter->onRenderFilter($this->section);
                        }
                        ?>
                        <button class="uk-button" type="button" title="Применить выбранные фильтры"
                                onclick="Joomla.submitbutton('records.filters')">Поиск
                        </button>
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
    <?php endif; ?>

    <!-- Панель меню -->
    <?php if ($markup->get('menu.menu')): ?>
        <div class="uk-navbar uk-margin-top">
            <!-- Вывод состояния фильтров -->
            <?php if ($this->worns): ?>
                <ul class="uk-navbar-nav">
                    <li>
                        <button class="uk-button uk-button-mini b0-filters-status" type="button"
                                data-uk-tooltip title="Сбросить все фильтры"
                                onclick="Joomla.submitbutton('records.cleanall')">
                            <i class="uk-icon-close uk-margin-right"></i>Очистить все фильтры
                        </button>
                    </li>

                    <?php foreach ($this->worns as $worn): ?>
                        <li>
                            <button type="button" class="uk-button uk-button-mini b0-filters-status"
                                    onclick="Cobalt.cleanFilter('<?= $worn->name; ?>')" data-uk-tooltip
                                    title="Удалить фильтр<br><?= $worn->text; ?>">
                                <i class="uk-icon-close uk-margin-right"></i><?= $worn->label . ': <span class="uk-text-bold">' . $worn->text . '</span>'; ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <!-- Вывод меню -->
            <div class="uk-navbar-flip">
                <ul class="uk-subnav uk-subnav-line">
                    <!-- Добавить запись -->
                    <?php if (!empty($this->postbuttons)): ?>
                        <?php
                        $submit = array_values($this->postbuttons);
                        $submit = array_shift($submit);
                        ?>
                        <li>
                            <a href="<?= Url::add($this->section, $submit, $this->category); ?>">
                                <i class="uk-icon-plus"></i>&nbsp;Добавить Техобслуживание
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Сортировка -->
                    <?php if (in_array($markup->get('menu.menu_ordering'), $this->user->getAuthorisedViewLevels()) && $this->items): ?>
                        <li data-uk-dropdown="{mode:'click'}">
                            <a href="#">
                                <i class="uk-icon-sort"></i>&nbsp;Сортировать по&nbsp;<i class="uk-icon-caret-down"></i>
                            </a>
                            <div class="uk-dropdown uk-panel uk-panel-box uk-panel-box-secondary">
                                <ul class="uk-nav uk-nav-dropdown">
                                    <li>
                                        <?= JHtml::_('mrelements.sort', 'Наименованию', 'r.title', $listDirn, $listOrder); ?>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="uk-clearfix"></div>

    <!-- Вывод статей -->
    <?php if ($this->items): ?>
        <?= $this->loadTemplate('list_' . $this->list_template); ?>

        <hr class="uk-article-divider">

        <?php if ($this->tmpl_params['list']->def('tmpl_core.item_pagination', 1)) : ?>
            <form method="post">
                <div style="text-align: center;">
                    <small>
                        <?php if ($this->pagination->getPagesCounter()): ?>
                            <?= $this->pagination->getPagesCounter(); ?>
                        <?php endif; ?>
                        <?php if ($this->tmpl_params['list']->def('tmpl_core.item_limit_box', 0)) : ?>
                            <?= str_replace('<option value="0">' . JText::_('JALL') . '</option>', '', $this->pagination->getLimitBox()); ?>
                        <?php endif; ?>
                        <?= $this->pagination->getResultsCounter(); ?>
                    </small>
                </div>
                <?php if ($this->pagination->getPagesLinks()): ?>
                    <div style="text-align: center;" class="pagination">
                        <?= str_replace('<ul>', '<ul class="pagination-list">', $this->pagination->getPagesLinks()); ?>
                    </div>
                    <div class="clearfix"></div>
                <?php endif; ?>
            </form>
        <?php endif; ?>

    <?php elseif ($this->worns):
        echo '<h4 align="center">К сожалению, по Вашему запросу ничего не найдено.</h4>';
    endif; ?>
<?php endif; ?>

<script>
    "use strict";
    let motorsArray = {
        "Logan": ["K7J (1.4 8V)", "K7M (1.6 8V)", "K4M (1.6 16V)", "H4M (1.6 16V)"],
        "Sandero": ["K7J (1.4 8V)", "K7M (1.6 8V)", "K4M (1.6 16V)"],
        "Duster": ["K4M (1.6 16V)", "F4R (2.0 16V)", "H4M (1.6 16V)", "K9K (1.5 8V dci)"],
        "Kaptur": ["F4R (2.0 16V)", "H4M (1.6 16V)"],
        "Dokker": ["K7M (1.6 8V)", "K9K (1.5 8V dci)"]
    };

    let yearsArray = {
        "Logan": ["2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018"],
        "Sandero": ["2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018"],
        "Sandero Stepway": ["2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018"],
        "Duster": ["2010", "2011", "2012", "2013", "2014", "2015", "2016", "2017", "2018"],
        "Kaptur": ["2016", "2017", "2018"],
        "Dokker": ["2018"]
    };

    let drivesArray = {
        "Logan": [],
        "Sandero": [],
        "Duster": ["2WD", "4WD"],
        "Kaptur": ["2WD", "4WD"],
        "Dokker": []
    };

    //Обработчик события изменения выбора модели
    (function ($) {

        $('#filtersk2c2d3a150ee055e8a427be13d2db1eb5value')
            .change(function () {
                setYears();
                setMotors();
                setDrives();
            })
            .change();
    })(jQuery);

    //Установка списка годов выпуска
    function setYears() {
        const modelName = jQuery('#filtersk2c2d3a150ee055e8a427be13d2db1eb5value').val();
        const modelInFilter = '<?= isset($this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']) ? $this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']->text : ''; ?>';
        const yearSet = jQuery('#filtersk188db5d9655bc4fcbb8bd1365184885evalue');

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
        const modelName = jQuery('#filtersk2c2d3a150ee055e8a427be13d2db1eb5value').val();
        const modelInFilter = '<?= isset($this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']) ? $this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']->text : ''; ?>';
        const motorSet = jQuery('#filterskdc66b066adb35de6d0e8f7a34554230evalue');
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

    //Установка списка приводов
    function setDrives() {
        const modelName = jQuery('#filtersk2c2d3a150ee055e8a427be13d2db1eb5value').val();
        const modelInFilter = '<?= isset($this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']) ? $this->worns['k2c2d3a150ee055e8a427be13d2db1eb5']->text : ''; ?>';
        const driveSet = jQuery('#filtersk608a63da4652b340b1e8df15b38c955dvalue');
        let optionsList = driveSet.children(':gt(0)');
        //console.log(drivesArray[modelName]);
        if (!modelName) {
            driveSet.val("");
            driveSet.attr("title", "Предварительно необходимо выбрать модель");
            driveSet.attr("disabled", true);
        }
        else if (drivesArray[modelName].length === 0) {
            driveSet.val("");
            driveSet.attr("title", "У модели " + modelName + " нет вариантов");
            driveSet.attr("disabled", true);
        }
        else {
            let optionsList = driveSet.children(':gt(0)');
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
            if (modelName !== modelInFilter) {
                driveSet.val("");
            }
            driveSet.attr("title", "При желании Вы можете выбрать привод для " + modelName);
            driveSet.attr("disabled", false);
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


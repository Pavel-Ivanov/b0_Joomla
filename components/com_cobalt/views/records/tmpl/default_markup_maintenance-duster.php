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

$duster_2010_2014_k4m_2wd = [
	'model'  => 'Renault Duster',
	'motor'  => '1.6 16V 2WD',
	'years'  => '2010-2014',
	'freq'   => 15000,
	'th'     => 'K4M (1.6 16V) / 2WD',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/3570-52a-tekhobsluzhivanie-renault-duster-15000-km-benzin-1-6-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/3574-53-tekhobsluzhivanie-renault-duster-30000-km-benzin-1-6-2010-2014',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/3571-52b-tekhobsluzhivanie-renault-duster-45000-km-to-3-benzin-1-6-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/3575-54-tekhobsluzhivanie-renault-duster-60000-km-benzin-1-6-2010-2014',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/3572-52c-tekhobsluzhivanie-renault-duster-75000-km-benzin-1-6-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/3576-55-tekhobsluzhivanie-renault-duster-90000-km-benzin-1-6-2010-2014',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/3573-52d-tekhobsluzhivanie-renault-duster-105000-km-benzin-1-6-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/3577-56-tekhobsluzhivanie-renault-duster-120000-km-benzin-1-6-2010-2014',
			'type'     => 'oil-ign-grm'
		]
	]
];
$duster_2010_2014_k4m_4wd = [
	'model'  => 'Renault Duster',
	'motor'  => '1.6 16V 4WD',
	'years'  => '2010-2014',
	'freq'   => 15000,
	'th'     => 'K4M (1.6 16V) / 4WD',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/3894-ds1-1a-tekhobsluzhivanie-renault-duster-15000-km-to-1-benzin-1-6-4wd-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/3895-ds1-2-tekhobsluzhivanie-renault-duster-30000-km-to-2-benzin-1-6-4wd-2010-2014',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/3896-ds1-1b-tekhobsluzhivanie-renault-duster-45000-km-to-3-benzin-1-6-4wd-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/3897-ds1-3-tekhobsluzhivanie-renault-duster-60000-km-to-4-benzin-1-6-4wd-2010-2014',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/3898-ds1-1c-tekhobsluzhivanie-renault-duster-75000-km-to-5-benzin-1-6-4wd-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/3899-ds1-4-tekhobsluzhivanie-renault-duster-90000-km-to-6-benzin-1-6-4wd-2010-2014',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/3892-ds1-1d-tekhobsluzhivanie-renault-duster-105000-km-to-7-benzin-1-6-4wd-2010-20144',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/3893-ds1-5-tekhobsluzhivanie-renault-duster-120000-km-to-8-benzin-1-6-4wd-2010-2014',
			'type'     => 'oil-ign-grm'
		]
	]
];
$duster_2010_2014_f4r_2wd = [
	'model'  => 'Renault Duster',
	'motor'  => '2.0 16V 2WD',
	'years'  => '2010-2014',
	'freq'   => 15000,
	'th'     => 'F4R (2.0 16V) / 2WD',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/3001-27a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/3005-28a-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/3002-27b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/3006-29-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/3003-27c-tekhnicheskoe-obsluzhivanie-probeg-75000-km-ili-3-goda',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/3007-30-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/3004-27d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/3008-31-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign-grm'
		]
	]
];
$duster_2010_2014_f4r_4wd = [
	'model'  => 'Renault Duster',
	'motor'  => '2.0 16V 4WD',
	'years'  => '2010-2014',
	'freq'   => 15000,
	'th'     => 'F4R (2.0 16V) / 4WD',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/3886-ds1-6a-tekhobsluzhivanie-renault-duster-15000-km-to-1-benzin-2-0-4wd-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/3887-ds1-7-tekhobsluzhivanie-renault-duster-30000-km-to-2-benzin-2-0-4wd-2010-2014',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/3888-ds1-6b-tekhobsluzhivanie-renault-duster-45000-km-to-3-benzin-2-0-4wd-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/3889-ds1-8-tekhobsluzhivanie-renault-duster-60000-km-to-4-benzin-2-0-4wd-2010-2014',
			'type'     => 'oil-ign-grm'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/3890-ds1-6c-tekhobsluzhivanie-renault-duster-75000-km-to-5-benzin-2-0-4wd-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/3891-ds1-9-tekhobsluzhivanie-renault-duster-90000-km-to-6-benzin-2-0-2-wd-2010-2014',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/3884-ds1-6d-tekhobsluzhivanie-renault-duster-105000-km-to-7-benzin-2-0-4wd-2010-2014',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/3885-ds1-10-tekhobsluzhivanie-renault-duster-120000-km-to-8-benzin-2-0-4wd-2010-2014',
			'type'     => 'oil-ign-grm'
		]
	]
];
$duster_2015_h4m_2wd = [
	'model'  => 'Renault Duster',
	'motor'  => '1.6 16V 2WD',
	'years'  => 'с 2015',
	'freq'   => 15000,
	'th'     => 'H4M (1.6 16V) / 2WD',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/2975-40a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2979-41a-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/2976-40b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/5113-tekhobsluzhivanie-renault-duster-60000-km-to-4-h4m-1-6-16v-2wd-2015-2017',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/2977-40c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2982-tekhnicheskoe-obsluzhivanie-probeg-60000-km-ili-4-goda',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/2978-40d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/2981-41c-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign'
		]
	]
];
$duster_2015_h4m_4wd = [
	'model'  => 'Renault Duster',
	'motor'  => '1.6 16V 4WD',
	'years'  => 'с 2015',
	'freq'   => 15000,
	'th'     => 'H4M (1.6 16V) / 4WD',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/3878-ds2-1a-tekhobsluzhivanie-renault-duster-2-15000-km-to-1-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/3879-ds2-2a-tekhobsluzhivanie-renault-duster-2-30000-km-to-2-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/3880-ds2-1b-tekhobsluzhivanie-renault-duster-2-45000-km-to-3-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/3881-ds2-2b-tekhobsluzhivanie-renault-duster-2-60000-km-to-4-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/3882-ds2-1c-tekhobsluzhivanie-renault-duster-2-75000-km-to-5-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/3883-ds2-3-tekhobsluzhivanie-renault-duster-2-90000-km-to-6-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil-ign-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/3876-ds2-1d-tekhobsluzhivanie-renault-duster-2-105000-km-to-7-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/3877-ds2-2c-tekhobsluzhivanie-renault-duster-2-120000-km-to-8-h4m-1-6-16v-4wd-2015-2017',
			'type'     => 'oil-ign'
		]
	]
];
$duster_2015_f4r_4wd = [
	'model'  => 'Renault Duster',
	'motor'  => '2.0 16V 4WD',
	'years'  => 'с 2015',
	'freq'   => 15000,
	'th'     => 'F4R (2.0 16V) / 4WD',
	'items'  => [
		[
			'milage' => 15000,
			'tdHref'   => '/maintenance/item/3553-49a-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/3557-50a-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 45000,
			'tdHref'   => '/maintenance/item/3554-49b-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/3558-50b-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-ign'
		],
		[
			'milage' => 75000,
			'tdHref'   => '/maintenance/item/3555-49c-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/3560-51-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-ign-grm-liq'
		],
		[
			'milage' => 105000,
			'tdHref'   => '/maintenance/item/3556-49d-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 120000,
			'tdHref'   => '/maintenance/item/3559-50c-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
			'type'     => 'oil-ign'
		]
	]
];
$duster_2010_2014_k9k_4wd = [
	'model'  => 'Renault Duster',
	'motor'  => '1.5 8V дизель 4WD',
	'years'  => '2010-2014',
	'freq'   => 10000,
	'th'     => 'K9K (1.5 8V дизель) / 4WD',
	'items'  => [
		[
			'milage' => 10000,
			'tdHref'   => '/maintenance/item/2992-32a-tekhnicheskoe-obsluzhivanie-probeg-10000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 20000,
			'tdHref'   => '/maintenance/item/2993-32b-tekhnicheskoe-obsluzhivanie-probeg-20000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2995-32c-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 40000,
			'tdHref'   => '/maintenance/item/2996-32d-tekhnicheskoe-obsluzhivanie-probeg-40000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 50000,
			'tdHref'   => '/maintenance/item/2994-32e-tekhnicheskoe-obsluzhivanie-probeg-50000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2999-33-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-grm'
		],
		[
			'milage' => 70000,
			'tdHref'   => '/maintenance/item/2997-32f-tekhnicheskoe-obsluzhivanie-probeg-70000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 80000,
			'tdHref'   => '/maintenance/item/2998-32g-tekhnicheskoe-obsluzhivanie-probeg-80000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/3000-34-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-liq'
		]
	]
];
$duster_2015_k9k_4wd = [
	'model'  => 'Renault Duster',
	'motor'  => '1.5 8V дизель 4WD',
	'years'  => 'с 2015',
	'freq'   => 10000,
	'th'     => 'K9K (1.5 8V дизель) / 4WD',
	'items'  => [
		[
			'milage' => 10000,
			'tdHref'   => '/maintenance/item/2983-36a-tekhnicheskoe-obsluzhivanie-probeg-10000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 20000,
			'tdHref'   => '/maintenance/item/2987-37a-tekhnicheskoe-obsluzhivanie-probeg-20000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 30000,
			'tdHref'   => '/maintenance/item/2984-36b-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 40000,
			'tdHref'   => '/maintenance/item/2988-37b-tekhnicheskoe-obsluzhivanie-probeg-40000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 50000,
			'tdHref'   => '/maintenance/item/2985-36c-tekhnicheskoe-obsluzhivanie-probeg-50000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 60000,
			'tdHref'   => '/maintenance/item/2990-38-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
			'type'     => 'oil-grm'
		],
		[
			'milage' => 70000,
			'tdHref'   => '/maintenance/item/2986-36d-tekhnicheskoe-obsluzhivanie-probeg-70000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 80000,
			'tdHref'   => '/maintenance/item/2989-37c-tekhnicheskoe-obsluzhivanie-probeg-80000-km',
			'type'     => 'oil'
		],
		[
			'milage' => 90000,
			'tdHref'   => '/maintenance/item/2991-39-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
			'type'     => 'oil-liq'
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
                <li><a href="#price">Сколько стоит техобслуживание Renault Duster</a></li>
                <li><a href="#why">Почему клиенты выбирают нас</a></li>
                <li><a href="#where">Где пройти техобслуживание Renault Duster</a></li>
                <li><a href="#guarantee">Гарантийные обязательства</a></li>
            </ul>
        </div>
    </div>
</div>
<hr class="uk-article-divider">

<p>
    Регулярное техническое обслуживание автомобиля Рено Дастер- это определяемый производителем список сервисных работ,
    выполняемых один раз в год или каждые 15 000 километров для бензиновых двигателей и 10 000 километров для дизельного мотора.
</p>
<p>
    Наш автосервис осуществляет качественное послегарантийное техобслуживание Рено Дастер. Будьте уверены,
    что Ваша машина в надежных руках, поскольку наши профессиональные автомеханики имеют многолетний опыт работы и
    производят сервисное обслуживание в соответствии с официальным регламентом Renault.
</p>

<div class="uk-panel uk-panel-box uk-margin-large-top">
    <h2 id="price" class="uk-text-center">Стоимость технического обслуживания Renault Duster</h2>
    <p class="uk-text-center">
        Выберите год выпуска, тип мотора и пробег.<br>Узнайте полную информацию о перечне и стоимости регламентных работ
        и рекомендуемых запчастей.
    </p>
</div>

<!-- 2010 - 2014 года выпуска (бензиновые моторы) -->
<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>2010 - 2014 года выпуска (бензиновые моторы)</h4>
</div>
<div class="uk-overflow-container">
    <table class="uk-table ls-table-condensed">
        <?php thead_benzin(); ?>
        <tbody>
            <!-- K4M (1.6 16V) 2WD -->
            <?php tbody_tr($duster_2010_2014_k4m_2wd);?>
            <!-- K4M (1.6 16V) 4WD -->
            <?php tbody_tr($duster_2010_2014_k4m_4wd);?>
            <!-- F4R (2.0 16V) 2WD -->
            <?php tbody_tr($duster_2010_2014_f4r_2wd);?>
            <!-- F4R (2.0 16V) 4WD -->
            <?php tbody_tr($duster_2010_2014_f4r_4wd);?>
        </tbody>
    </table>
</div>

<!-- c 2015 года выпуска (бензиновые моторы) -->
<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>с 2015 года выпуска (бензиновые моторы)</h4>
</div>
<div class="uk-overflow-container">
<table class="uk-table ls-table-condensed">
    <?php thead_benzin(); ?>
    <tbody>
        <?php tbody_tr($duster_2015_h4m_2wd);?>
        <?php tbody_tr($duster_2015_h4m_4wd);?>
        <?php tbody_tr($duster_2015_f4r_4wd);?>
    </tbody>
</table>
</div>

<!-- 2010 - 2014 года выпуска (дизельный мотор) -->
<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>2010 - 2014 года выпуска (дизельный мотор)</h4>
</div>
<div class="uk-overflow-container">
<table class="uk-table ls-table-condensed">
    <?php thead_dizel(); ?>
    <tbody>
        <!-- Duster 1.5 дизель 4WD 2010-2014 -->
        <?php tbody_tr($duster_2010_2014_k9k_4wd);?>
    </tbody>
</table>
</div>

<!-- с 2015 года выпуска (дизельный мотор) -->
<div class="uk-panel uk-panel-box uk-margin-top">
    <h4>с 2015 года выпуска (дизельный мотор)</h4>
</div>
<div class="uk-overflow-container">
<table class="uk-table ls-table-condensed">
    <?php thead_dizel(); ?>
    <tbody>
    <!-- Duster 1.5 дизель 4WD c 2015 -->
    <?php tbody_tr($duster_2015_k9k_4wd);?>
    </tbody>
</table>
</div>

<div class="uk-panel uk-panel-box uk-margin-large-top uk-margin-bottom">
    <h2 id="why" class="uk-text-center">Почему клиенты выбирают нас</h2>
</div>
{module 159}

<div class="uk-panel uk-panel-box uk-margin-large-top uk-margin-bottom">
    <h2 id="where" class="uk-text-center">Где пройти техобслуживание Renault Duster</h2>
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
        "Logan": ["K7J (1.4 8V)", "K7M (1.6 8V)", "K4M (1.6 16V)"],
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


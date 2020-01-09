<?php
defined('_JEXEC') or die();

$config = [
	'с 2018 года выпуска (бензиновый мотор)' => [
		'type' => 'benzin',
		'motors' => [
			'K7M (1.6 8V)' => [
				'type' => 'benzin',
				'model'  => 'Renault Dokker',
				'motor'  => '1.6 8V',
				'years'  => 'с 2018',
				'freq'   => 15000,
				'th'     => 'K7M (1.6 8V)',
				'items'  => [
					[
						'milage' => 15000,
						'tdHref'   => '/maintenance/item/5323-tekhnicheskoe-obsluzhivanie-probeg-15000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 30000,
						'tdHref'   => '/maintenance/item/5324-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
						'type'     => 'oil-ign'
					],
					[
						'milage' => 45000,
						'tdHref'   => '/maintenance/item/5325-tekhnicheskoe-obsluzhivanie-probeg-45000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 60000,
						'tdHref'   => '/maintenance/item/5326-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
						'type'     => 'oil-ign'
					],
					[
						'milage' => 75000,
						'tdHref'   => '/maintenance/item/5327-tekhnicheskoe-obsluzhivanie-probeg-75000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 90000,
						'tdHref'   => '/maintenance/item/5328-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
						'type'     => 'oil-ign-grm-liq'
					],
					[
						'milage' => 105000,
						'tdHref'   => '/maintenance/item/5329-tekhnicheskoe-obsluzhivanie-probeg-105000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 120000,
						'tdHref'   => '/maintenance/item/5330-tekhnicheskoe-obsluzhivanie-probeg-120000-km',
						'type'     => 'oil-ign'
					]
				]
			],
		],
	],
	'с 2018 года выпуска (дизельный мотор)' => [
		'type' => 'dizel',
		'motors' => [
			'K9K (1.5 8V дизель)' => [
				'type' => 'dizel',
				'model'  => 'Renault Dokker',
				'motor'  => '1.5 8V дизель',
				'years'  => 'с 2018',
				'freq'   => 10000,
				'th'     => 'K9K (1.5 8V дизель)',
				'items'  => [
					[
						'milage' => 10000,
						'tdHref'   => '/maintenance/item/5314-tekhnicheskoe-obsluzhivanie-probeg-10000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 20000,
						'tdHref'   => '/maintenance/item/5315-tekhnicheskoe-obsluzhivanie-probeg-20000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 30000,
						'tdHref'   => '/maintenance/item/5316-tekhnicheskoe-obsluzhivanie-probeg-30000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 40000,
						'tdHref'   => '/maintenance/item/5317-tekhnicheskoe-obsluzhivanie-probeg-40000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 50000,
						'tdHref'   => '/maintenance/item/5318-tekhnicheskoe-obsluzhivanie-probeg-50000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 60000,
						'tdHref'   => '/maintenance/item/5319-tekhnicheskoe-obsluzhivanie-probeg-60000-km',
						'type'     => 'oil-grm'
					],
					[
						'milage' => 70000,
						'tdHref'   => '/maintenance/item/5320-tekhnicheskoe-obsluzhivanie-probeg-70000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 80000,
						'tdHref'   => '/maintenance/item/5321-tekhnicheskoe-obsluzhivanie-probeg-80000-km',
						'type'     => 'oil'
					],
					[
						'milage' => 90000,
						'tdHref'   => '/maintenance/item/5322-tekhnicheskoe-obsluzhivanie-probeg-90000-km',
						'type'     => 'oil-liq'
					]
				]
			],
		],
	],
];

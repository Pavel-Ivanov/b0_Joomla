<?php
defined('_JEXEC') or die();

/**
 * Class YmlConfig
 * Константы конфигурации
 */
class YmlConfig
{
	public const YML_ITEMS_LIMIT = 0;  // Ограничение количества записей в запросе
	public const YML_YFULL_FILE_PATH = "/yml-spareparts.xml";    // Относительный путь файла логов
	public const YML_YMARKET_FILE_PATH = "/ymarket.xml";    // Относительный путь конечного файла
	
	public const YML_NAME = "Логан Шоп СПб";    // Название
	public const YML_COMPANY = "Логан Шоп СПб";    // Название компании
	public const YML_URL = "https://logan-shop.spb.ru";    // Ссылка на сайт
	public const YML_CURRENCY = "RUB";    // Валюта
	public const YML_CURRENCY_RATE = "1";    // Курс валюты
	
	public const YML_FIELD_ID = "229";  // Аксессуары
	
	public const YML_DELIVERY_OPTIONS = [    // Массив опций доставки
		[
			'cost' => '0',
			'days' => '1-2',
			'order-before' => ''
		],
	];
}

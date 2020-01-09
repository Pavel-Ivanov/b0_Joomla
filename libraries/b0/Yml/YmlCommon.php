<?php
defined('_JEXEC') or die('Restricted access');

class YmlCommon
{
	const YML_LOG_FILE_PATH = "/yml-spareparts.xml";    // Относительный путь конечного файла
	const YML_NAME = "Логан-Шоп СПб";    // Название
	const YML_COMPANY = "Логан-Шоп СПб";    // Название компании
	const YML_URL = "https://logan-shop.spb.ru";    // Ссылка на сайт
	const YML_CURRENCY = "RUB";    // Валюта
	const YML_CURRENCY_RATE = "1";    // Курс валюты
	const YML_CATEGORIES = [      // Массив категорий товаров
		"1" => "Рулевое",
		"2" => "Ходовая",
		"3" => "Трансмиссия",
		"4" => "Тормоза",
		"5" => "Кузов",
		"6" => "Салон",
		"7" => "Электрика",
		"8" => "Масла",
		"9" => "Фильтры",
		"10" => "Лампы",
		"11" => "Диски",
		"12" => "Крепеж",
		"13" => "Чехлы",
		"14" => "Ковры",
		"15" => "Багажники",
		"16" => "Инструмент",
		"17" => "Литература",
		"18" => "Прочее",
		"19" => "Двигатель",
	];
	const YML_DELIVERY_OPTIONS = [    // Массив опций доставки
		[
			"option" => "cost",
			"value" => "1-2"
		],
	];
}

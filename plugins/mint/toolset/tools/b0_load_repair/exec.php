<?php
include_once JPATH_ROOT.'/components/com_cobalt/api.php';

$app = JFactory::getApplication();

$fileName = JPATH_ROOT . '/uploads/'.$params->get('files');
//$logs = [];
$file_handle = fopen($fileName, "r");
if ($file_handle == false) {
	//$logs[] = 'Logan-Shop SiteMap - Ошибка открытия файла '. $fileName;
	$app->enqueueMessage('Ошибка открытия файла ' . $fileName, 'error');
	return;
}

$section_id = $params->get('section_id', 0);
$type_id = $params->get('type_id', 0);
$category= $params->get('category', '');

while (($data_string = fgetcsv($file_handle, 1500, ";")) !== FALSE) {
	// проверка на пустую строку
	if ($data_string[0] == '#') continue;

	// проверка на выгрузку на сайт Logan-Shop
	if ($data_string[7] == 'Нет') continue;

	$dataType = getDataType($data_string);
	$data = getData($dataType, $data_string);
	$fields = getFields($dataType, $data_string);
	$categories = getCategories($dataType, $category);
	CobaltApi::createRecord($data, $section_id, $type_id, $fields, $categories);
	//CobaltApi::touchRecord(0, $section_id, $type_id, $data, $fields, $categories);
}

fclose($file_handle);

$app->enqueueMessage('Раздел загружен успешно', 'notice');

function getDataType ($data_string) {
	return $data_string[10];
}

function getData ($dataType, $data_string) {
	$models = getModels($dataType);
	$title = $data_string[0];
	// удаляем (с/у)
	$title = trim(str_ireplace('(с/у)', '', $title));
	// если тип не 0, вставляем модели
	if ($dataType != '0') {
		// получаем список моделей

		//вставляем названия моделей
		$pos = mb_strpos($title, '.')-2;
		$title = mb_substr($title, 0, $pos) . $models . mb_substr($title, $pos);
	}

	if ($data_string[11]) {
		$metaDescr = $data_string[11]. ' Renault' . $models . getConfigs($dataType);
	}
	else {
		$metaDescr = $title;
	}

	$data = [
		'title' => $title,
		'meta_descr' => $metaDescr,
		'access' => 1,
		'published' => 1
	];
	return $data;
}

function getFields ($dataType, $dataString) {
	switch ($dataType) {
		case '0':
			$fields = [
				67 => $dataString[3],    // ID_1C
				64 => $dataString[2],    // Подзаголовок
				5  => $dataString[1],    // Цена
				// Модели
				11 => ['Logan','Sandero', 'Duster', 'Kaptur'],
				// Года выпуска
				'63' => ['2005','2006','2007','2008','2009','2010','2011','2012','2013','2014','2015','2016','2017'],
				// Моторы
				'55' => ['K7J (1.4 8V)', 'K7M (1.6 8V)', 'K4M (1.6 16V)', 'H4M (1.6 16V)', 'F4R (2.0 16V)', 'K9K (1.5 8V dci)'],
				// Модификации
				'54' => ['2WD', '4WD']
			];
			break;
		case '1':
			$fields = [
				67 => $dataString[3],    // ID_1C
				64 => $dataString[2],    // Подзаголовок
				5  => $dataString[1],    // Цена
				// Модели
				11 => ['Logan','Sandero'],
				// Года выпуска
				'63' => ['2005','2006','2007','2008','2009','2010','2011','2012','2013','2014','2015','2016','2017'],
				// Моторы
				'55' => ['K7J (1.4 8V)', 'K7M (1.6 8V)'],
				// Модификации
				'54' => ['2WD']
			];
			break;
		case '2':
			$fields = [
				67 => $dataString[3],    // ID_1C
				64 => $dataString[2],    // Подзаголовок
				5  => $dataString[1],    // Цена
				// Модели
				11 => ['Logan','Sandero', 'Duster', 'Kaptur'],
				// Года выпуска
				63 => ['2010','2011','2012','2013','2014','2015','2016','2017'],
				// Моторы
				55 => ['K4M (1.6 16V)', 'H4M (1.6 16V)'],
				// Модификации
				54 => ['2WD']
			];
			break;
		case '3':
			$fields = [
				67 => $dataString[3],    // ID_1C
				64 => $dataString[2],    // Подзаголовок
				5  => $dataString[1],    // Цена
				// Модели
				11 => ['Duster'],
				// Года выпуска
				63 => ['2012','2013','2014','2015','2016','2017'],
				// Моторы
				55 => ['K4M (1.6 16V)', 'H4M (1.6 16V)'],
				// Модификации
				54 => ['4WD']
			];
			break;
		case '4':
			$fields = [
				67 => $dataString[3],    // ID_1C
				64 => $dataString[2],    // Подзаголовок
				5  => $dataString[1],    // Цена
				// Модели
				11 => ['Duster'],
				// Года выпуска
				63 => ['2012','2013','2014'],
				// Моторы
				55 => ['F4R (2.0 16V)'],
				// Модификации
				54 => ['2WD']
			];
			break;
		case '5':
			$fields = [
				67 => $dataString[3],    // ID_1C
				64 => $dataString[2],    // Подзаголовок
				5  => $dataString[1],    // Цена
				// Модели
				11 => ['Duster', 'Kaptur'],
				// Года выпуска
				63 => ['2012','2013','2014','2015','2016','2017'],
				// Моторы
				55 => ['F4R (2.0 16V)'],
				// Модификации
				54 => ['4WD']
			];
			break;
		case '6':
			$fields = [
				67 => $dataString[3],    // ID_1C
				64 => $dataString[2],    // Подзаголовок
				5  => $dataString[1],    // Цена
				// Модели
				11 => ['Duster'],
				// Года выпуска
				63 => ['2012','2013','2014','2015','2016','2017'],
				// Моторы
				55 => ['K9K (1.5 8V dci)'],
				// Модификации
				54 => ['4WD']
			];
			break;
		default:
			$fields = [];
	}
	return $fields;
}

function getCategories ($dataType, $category) {
	switch ($dataType)
	{
		case '0':   //Logan, Sandero, Duster, Kaptur
			switch ($category) {
				case 'engine':
					$categories = [107, 108, 109, 110];
					break;
				case 'steering':
					$categories = [111, 112, 113, 114];
					break;
				case 'run':
					$categories = [115, 116, 117, 118];
					break;
				case 'transmission':
					$categories = [119, 120, 121, 122];
					break;
				case 'braking':
					$categories = [123, 124, 125, 126];
					break;
				case 'body':
					$categories = [127, 128, 129, 130];
					break;
				case 'salon':
					$categories = [131, 132, 133, 134];
					break;
				case 'electric':
					$categories = [135, 136, 137, 138];
					break;
				case 'tires':
					$categories = [139, 140, 141, 142];
					break;
				case 'reglament':
					$categories = [143, 144, 145, 146];
					break;
				default:
					$categories = [];
			}
			break;
		case '1':   // Logan, Sandero
			switch ($category) {
				case 'engine':
					$categories = [107, 108];
					break;
				case 'steering':
					$categories = [111, 112];
					break;
				case 'run':
					$categories = [115, 116];
					break;
				case 'transmission':
					$categories = [119, 120];
					break;
				case 'braking':
					$categories = [123, 124];
					break;
				case 'body':
					$categories = [127, 128];
					break;
				case 'salon':
					$categories = [131, 132];
					break;
				case 'electric':
					$categories = [135, 136];
					break;
				case 'tires':
					$categories = [139, 140];
					break;
				case 'reglament':
					$categories = [143, 144];
					break;
				default:
					$categories = [];
			}
			break;
		case '2':   //Logan, Sandero, Duster, Kaptur
			switch ($category) {
				case 'engine':
					$categories = [107, 108, 109, 110];
					break;
				case 'steering':
					$categories = [111, 112, 113, 114];
					break;
				case 'run':
					$categories = [115, 116, 117, 118];
					break;
				case 'transmission':
					$categories = [119, 120, 121, 122];
					break;
				case 'braking':
					$categories = [123, 124, 125, 126];
					break;
				case 'body':
					$categories = [127, 128, 129, 130];
					break;
				case 'salon':
					$categories = [131, 132, 133, 134];
					break;
				case 'electric':
					$categories = [135, 136, 137, 138];
					break;
				case 'tires':
					$categories = [139, 140, 141, 142];
					break;
				case 'reglament':
					$categories = [143, 144, 145, 146];
					break;
				default:
					$categories = [];
			}
			break;
		case '3':   //Duster
			switch ($category) {
				case 'engine':
					$categories = [109];
					break;
				case 'steering':
					$categories = [113];
					break;
				case 'run':
					$categories = [117];
					break;
				case 'transmission':
					$categories = [121];
					break;
				case 'braking':
					$categories = [125];
					break;
				case 'body':
					$categories = [129];
					break;
				case 'salon':
					$categories = [133];
					break;
				case 'electric':
					$categories = [137];
					break;
				case 'tires':
					$categories = [141];
					break;
				case 'reglament':
					$categories = [145];
					break;
				default:
					$categories = [];
			}
			break;
		case '4':   //Duster
			switch ($category) {
				case 'engine':
					$categories = [109];
					break;
				case 'steering':
					$categories = [113];
					break;
				case 'run':
					$categories = [117];
					break;
				case 'transmission':
					$categories = [121];
					break;
				case 'braking':
					$categories = [125];
					break;
				case 'body':
					$categories = [129];
					break;
				case 'salon':
					$categories = [133];
					break;
				case 'electric':
					$categories = [137];
					break;
				case 'tires':
					$categories = [141];
					break;
				case 'reglament':
					$categories = [145];
					break;
				default:
					$categories = [];
			}
			break;
		case '5':   //Duster, Kaptur
			switch ($category) {
				case 'engine':
					$categories = [109, 110];
					break;
				case 'steering':
					$categories = [113, 114];
					break;
				case 'run':
					$categories = [117, 118];
					break;
				case 'transmission':
					$categories = [121, 122];
					break;
				case 'braking':
					$categories = [125, 126];
					break;
				case 'body':
					$categories = [129, 130];
					break;
				case 'salon':
					$categories = [133, 134];
					break;
				case 'electric':
					$categories = [137, 138];
					break;
				case 'tires':
					$categories = [141, 142];
					break;
				case 'reglament':
					$categories = [145, 146];
					break;
				default:
					$categories = [];
			}
			break;
		case '6':   //Duster
			switch ($category) {
				case 'engine':
					$categories = [109];
					break;
				case 'steering':
					$categories = [113];
					break;
				case 'run':
					$categories = [117];
					break;
				case 'transmission':
					$categories = [121];
					break;
				case 'braking':
					$categories = [125];
					break;
				case 'body':
					$categories = [129];
					break;
				case 'salon':
					$categories = [133];
					break;
				case 'electric':
					$categories = [137];
					break;
				case 'tires':
					$categories = [141];
					break;
				case 'reglament':
					$categories = [145];
					break;
				default:
					$categories = [];
			}
			break;
		default:
			$categories = [];
	}
	return $categories;
}

function getModels ($dataType) {
	switch ($dataType) {
		case '0':
			$models = ' Logan, Sandero, Duster, Kaptur';
			break;
		case '1':
			$models = ' Logan, Sandero';
			break;
		case '2':
			$models = ' Logan, Sandero, Duster, Kaptur';
			break;
		case '3':
			$models = ' Duster';
			break;
		case '4':
			$models = ' Duster';
			break;
		case '5':
			$models = ' Duster, Kaptur';
			break;
		case '6':
			$models = ' Duster';
			break;
		default:
			$models = '';
			break;
	}
	return $models;
}

function getConfigs ($dataType) {
	switch ($dataType) {
		case '0':
			$configs = '';
			break;
		case '1':
			$configs = ' 1.4/1.6 8V 2WD';
			break;
		case '2':
			$configs = ' 1.6 16V 2WD';
			break;
		case '3':
			$configs = ' 1.6 16V 4WD';
			break;
		case '4':
			$configs = ' 2.0 16V 2WD';
			break;
		case '5':
			$configs = ' 2.0 16V 4WD';
			break;
		case '6':
			$configs = ' 1.5 дизель 4WD';
			break;
		default:
			$configs = '';
			break;
	}
	return $configs;
}

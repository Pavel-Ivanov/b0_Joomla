<?php
JImport('b0.fixtures');
require_once JPATH_ROOT . '/components/com_cobalt/api.php';

$excluded_id = [5992,5610,5605,4921,4881,3952,4922,4923,5603,5606,4051,5607,5993,5612,5611,4852,5609,4851,4875,
	4655,4678,5514,5805,5898,5744,3910,4850,4209,4210,4211,4906,4808,4912,4336,4677,5730,5743,5746,5747,5748,
	5749,5750,5806,5745,5891,5899,5900,5901,5902];

$app = JFactory::getApplication();

// Проверяем введенные параметры
// Выбранный раздел
if (!$params['section_id']) {
	$app->enqueueMessage('Не выбран Раздел');
	return;
}
else {
	$section_id = stristr($params['section_id'], ':', true);
}

//Поле, в котором ищем контрольные значения $value_to_search_1
if (!$params['field_id_to_search_1']) {
	$app->enqueueMessage('Не выбрано поле, в котором искать');
	return;
}
else {
	$field_id_to_search_1 =$params['field_id_to_search_1'];
}

//Значение, которое ищем
if (!$params['value_to_search_1']) {
	$app->enqueueMessage('Не выбрано значение для поиска');
	return;
}
else {
	$value_to_search_1 = $params['value_to_search_1'];
}

if (!$params['field_id_to_search_2']) {
	$field_id_to_search_2 = 0;
}
else {
	$field_id_to_search_2 =$params['field_id_to_search_2'];
}

if (!$params['value_to_search_2']) {
	$value_to_search_2 = '';
}
else {
	$value_to_search_2 = $params['value_to_search_2'];
}

//Поле, в которое добавляем значение $value_to_add
if (!$params['field_id_to_add']) {
	$app->enqueueMessage('Не выбрано поле, в которое добавляем');
	return;
}
else {
	$field_id_to_add   = $params['field_id_to_add'];
}

//Значение, которое добавляем
if (!$params['value_to_add']) {
	$app->enqueueMessage('Не выбрано поле, в которое добавляем');
	return;
}
else {
	$value_to_add   = $params['value_to_add'];
}

//Сколько выбирать записей в формате
$limit_start = $params['search_limit_start'];
$limit_number = $params['search_limit_number'];

// Проверяем запись в файл лога
$file_path = JPATH_ROOT . "/logs/b0_add_arkana_log.txt";
$file_handle = fopen($file_path, "a+");
if ($file_handle == false) {
	$app->enqueueMessage('Ошибка открытия файла add_arkana_log.txt');
	return;
}

$res = fwrite($file_handle, '===== ' . date_format(new DateTime(), 'Y-m-d H:i:s') . ' =====' . "\n");
if ($res == false) {
	$app->enqueueMessage('Ошибка записи в файл add_arkana_log.txt');
	fclose($file_handle);
	return;
}

$log_str = 'Добавляем: '. $value_to_add .' если установлен: '.$value_to_search_1;
if ($params['value_to_search_2']) {
	$log_str .= ' и ' . $value_to_search_2;
}
$log_str .= "\n";
$res = fwrite($file_handle, $log_str);

// Получаем записи из БД
$db  = JFactory::getDbo();
$query = "SELECT * FROM #__js_res_record
	WHERE section_id={$section_id}
	AND id IN (SELECT record_id FROM #__js_res_record_values WHERE (field_id={$field_id_to_search_1} AND field_value='{$value_to_search_1}'))";

if ($field_id_to_search_2 != 0) {
	$query .= " AND id IN (SELECT record_id FROM #__js_res_record_values WHERE (field_id={$field_id_to_search_2} AND field_value='{$value_to_search_2}'))";
}
$query .= " ORDER BY title ";
if ($limit_number > 0) {
	$query .= " LIMIT {$limit_start},{$limit_number}";
}
fwrite($file_handle, $query . "\n");

$db->setQuery($query);
$items = $db->loadObjectList();

if (empty($items)) {
	fwrite($file_handle, 'Пустой запрос, нечего менять' . "\n");
	fclose($file_handle);
	$app->enqueueMessage('B0 add arkana - Пустой запрос, нечего менять');
	return;
}

foreach($items as $item) {
	$str = $item->id . ' : ' . $item->title;
	
	// проверяем на наличие в списке исключения
	if (array_search($item->id, $excluded_id)) {
		$str .= ' / запись в списке исключенных, пропускаем';
//		b0dd($item->id);
		fwrite($file_handle, $str . "\n");
		continue;
	}
	
	// проверяем на наличие ГУР в названии
	if (mb_stripos($item->title, 'гур')) {
		$str .= ' / в названии есть ГУР, пропускаем';
		fwrite($file_handle, $str . "\n");
		continue;
	}
	
	//***** Установка полей
	$fields = json_decode($item->fields, TRUE);
	
	if (!isset($fields[$field_id_to_add])) {
		$str .= ' / отсутствует $fields[$field_id_to_add], пропускаем';
		fwrite($file_handle, $str . "\n");
		continue;
	}
	if(empty($fields[$field_id_to_add])) {
		$str .= ' / пустое $fields[$field_id_to_add], пропускаем';
		fwrite($file_handle, $str . "\n");
		continue;
	}
	
	// проверяем на наличие добавляемого значения
	if (array_search($value_to_add, $fields[$field_id_to_add])) {
		$str .= ' / модель уже установлена, пропускаем';
		fwrite($file_handle, $str . "\n");
		continue;
	}
	else {
		array_push($fields[$field_id_to_add], $value_to_add);
	}
	
	// добавляем мотор TCe150 / HR13DDT (1,3 16V)
	if (array_search('TCe150 / HR13DDT (1,3 16V)', $fields['55'])) {
		$str .= ' / мотор TCe150 / HR13DDT (1,3 16V) уже установлен, пропускаем';
		fwrite($file_handle, $str . "\n");
		continue;
	}
	else {
		array_push($fields['55'], 'TCe150 / HR13DDT (1,3 16V)');
	}
	
	//***** Установка категорий
	$cats = json_decode($item->categories, TRUE);
	$categories = array_keys($cats);
	// Двигатель
	if (array_key_exists(109, $cats)) {
		$categories[] = 165;
	}
	// Рулевое
	elseif (array_key_exists(113, $cats)) {
		$categories[] = 166;
	}
	// Ходовая
	elseif (array_key_exists(117, $cats)) {
		$categories[] = 167;
	}
	// Трансмиссия
	elseif (array_key_exists(121, $cats)) {
		$categories[] = 168;
	}
	// Тормоза
	elseif (array_key_exists(125, $cats)) {
		$categories[] = 169;
	}
	// Кузов
	elseif (array_key_exists(129, $cats)) {
		$categories[] = 170;
	}
	// Салон
	elseif (array_key_exists(133, $cats)) {
		$categories[] = 171;
	}
	// Электрика
	elseif (array_key_exists(137, $cats)) {
		$categories[] = 172;
	}
	// Шиномонтаж
	elseif (array_key_exists(141, $cats)) {
		$categories[] = 173;
	}
	// Регламентные работы
	elseif (array_key_exists(145, $cats)) {
		$categories[] = 174;
	}
	
	$data = [];
	//***** Установка названия
	//b0dd(mb_stripos($item->title, 'Duster'));
	if (mb_stripos($item->title, 'arkana')) {
		$str .= ' / в названии есть Arkana, не добавляем';
		fwrite($file_handle, $str . "\n");
	}
	elseif (mb_stripos($item->title, 'Duster')) {
		$posTitle = mb_stripos($item->title, 'Duster');
		$newTitle = mb_substr_replace($item->title, ', Arkana', $posTitle+6, 0);
		$data['title'] = $newTitle;
	}
	
	//***** Установка meta Description
	if (mb_stripos($item->meta_descr, 'arkana')) {
		$str .= ' / в meta Description есть Arkana, не добавляем';
		fwrite($file_handle, $str . "\n");
	}
	elseif (mb_stripos($item->meta_descr, 'Duster')) {
		$posMetaDescription = mb_stripos($item->meta_descr, 'Duster');
		$newMetaDescription = mb_substr_replace($item->meta_descr, ', Arkana', $posMetaDescription+6, 0);
	}
	$data['meta_descr'] = $newMetaDescription;
	
	if (!CobaltApi::updateRecord((int) $item->id, $data, $fields, $categories)) {
		fwrite($file_handle,$str .= ' / ошибка обновления записи' . "\n");
		continue;
	};

	$str .= ' / установлено';
	fwrite($file_handle, $str . "\n");
}

fwrite($file_handle, 'Успешно выполнено' . "\n");
fclose($file_handle);
$app->enqueueMessage('B0 add Arkana - успешно выполнено');

/**
 * @param string $original
 * @param string $replacement
 * @param int    $position
 * @param int    $length
 *
 * @return string
 */
function mb_substr_replace(string $original, string $replacement, int $position, int $length)
{
	$startString = mb_substr($original, 0, $position, "UTF-8");
	$endString = mb_substr($original, $position + $length, mb_strlen($original), "UTF-8");
	
	$out = $startString . $replacement . $endString;
	
	return $out;
}

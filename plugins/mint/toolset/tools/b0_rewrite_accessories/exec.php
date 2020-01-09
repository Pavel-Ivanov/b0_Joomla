<?php
require_once JPATH_ROOT . '/components/com_cobalt/api.php';
JImport('b0.Sparepart.SparepartKeys');
JImport('b0.Sparepart.SparepartIds');
JImport('b0.Accessory.AccessoryIds');
JImport('b0.fixtures');

$app = JFactory::getApplication();

$section_spareparts_id = SparepartIds::ID_SECTION;    // Запчасти
$section_accessories_id = AccessoryIds::ID_SECTION;    // Аксессуары
$type_accessories_id = AccessoryIds::ID_TYPE;    // Аксессуары
$field_image_accessories_id = AccessoryIds::ID_IMAGE;    // Аксессуары
$field_category_id = 50;    // Поле категория


//Сколько выбирать записей в формате
$limit_number = $params['search_limit_number'];
// Проверяем запись в файл лога
$file_path = JPATH_ROOT . "/logs/b0_rewrite_accessories_log.txt";
$file_handle = fopen($file_path, "a+");
if ($file_handle == false) {
	$app->enqueueMessage('B0 move to Accessories - Ошибка открытия файла b0_rewrite_accessories_log.txt');
	return;
}

$res = fwrite($file_handle, '===== ' . date_format(new DateTime(), 'Y-m-d H:i:s') . ' =====' . "\n");
if ($res == false) {
	$app->enqueueMessage('B0 move to Accessories - Ошибка записи в файл b0_rewrite_accessories_log.txt');
	fclose($file_handle);
	return;
}

// Получаем записи из БД
$db  = JFactory::getDbo();
$query = "SELECT id, title FROM #__js_res_record WHERE section_id={$section_accessories_id}";
if ($limit_number > 0) {
	$query .= " LIMIT 0,{$limit_number}";
}
//fwrite($file_handle, $query . "\n");
//b0dd($query);

$db->setQuery($query);
$items = $db->loadObjectList();
if (empty($items)) {
	fwrite($file_handle, 'Пустой запрос, нечего менять' . "\n");
	fclose($file_handle);
	$app->enqueueMessage('B0 rewrite Accessories - Пустой запрос, нечего менять');
	return;
}
//b0dd($items);


foreach($items as $item)
{
	$record = JTable::getInstance('Record', 'CobaltTable');
	$record->load($item->id);
	$str = $item->id . ' : ' . $item->title;
	$fields = json_decode($record->fields, true);
	//b0dd($fields);
	CobaltApi::updateRecord($item->id, [], $fields);
	$str .= ' / заменено';
	$app->enqueueMessage($str);
	fwrite($file_handle, $str . "\n");
}

fwrite($file_handle, 'Успешно завершено' . "\n");
fclose($file_handle);
$app->enqueueMessage('B0 move to Accessories - Успешно завершено');




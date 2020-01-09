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

// Проверяем введенные параметры
// Выбранная категория
//b0dd($params['category']);
if (!$params['category']) {
	$app->enqueueMessage(JText::_('Не выбрана Категория'));
	return;
}
else {
	//$category_id = stristr($params['category'], ':', true);
	$category_name = $params['category'];
}
//b0dd($categoryName);

//Сколько выбирать записей в формате
$limit_start = $params['search_limit_start'];
$limit_number = $params['search_limit_number'];
// Проверяем запись в файл лога
$file_path = JPATH_ROOT . "/logs/b0_move_to_accessories_log.txt";
$file_handle = fopen($file_path, "a+");
if ($file_handle == false) {
	$app->enqueueMessage('B0 move to Accessories - Ошибка открытия файла b0_move_to_accessories_log.txt');
	return;
}

$res = fwrite($file_handle, '===== ' . date_format(new DateTime(), 'Y-m-d H:i:s') . ' =====' . "\n");
if ($res == false) {
	$app->enqueueMessage('B0 move to Accessories - Ошибка записи в файл b0_move_to_accessories_log.txt');
	fclose($file_handle);
	return;
}

// Получаем записи из БД
$db  = JFactory::getDbo();
$query = "SELECT id, title FROM #__js_res_record WHERE section_id={$section_spareparts_id}
	AND id IN(SELECT record_id FROM #__js_res_record_values WHERE field_id={$field_category_id} AND field_value='{$category_name}') ORDER BY title";
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
	$app->enqueueMessage('B0 move to Accessories - Пустой запрос, нечего менять');
	return;
}
//b0dd($items);

foreach($items as $item)
{
	$record = JTable::getInstance('Record', 'CobaltTable');
	$record->load($item->id);
	//b0dd($record);
	$str = $record->id . ' : ' . $record->title;
	//b0dd($record);
	$record->section_id = AccessoryIds::ID_SECTION;
	$record->type_id = AccessoryIds::ID_TYPE;
	$newFields = setFields($record);
	//b0dd($newFields[AccessoryIds::ID_MODEL]);
	$record->fields = json_encode($newFields);
	//b0dd($newFields[AccessoryIds::ID_MODEL]);
	$newCategories = setCategories($newFields[AccessoryIds::ID_MODEL]);
	//b0dd($newCategories);
	$record->categories = json_encode($newCategories);
	//b0dd($record);
	$result = $record->store();
	//b0debug($result);

	// Запись в таблицу record_category
	foreach ($newCategories as $key => $category) {
		$tableCategory = JTable::getInstance('Record_category', 'CobaltTable');
		$categoryData = [
			'catid' => (int) $key,
			'record_id' => $item->id,
			'ordering' => 0,
			'otime' => null,
			'section_id' => (int) AccessoryIds::ID_SECTION,
			'published' => 1,
			'access' => 1,
		];
		$tableCategory->bind($categoryData);
		$tableCategory->store();
	}

	// Очищаем таблицу record_values
	$query = $db->getQuery(true);
	$query->delete($db->quoteName('#__js_res_record_values'));
	$query->where('record_id='.$item->id);
	$db->setQuery($query);
	$result = $db->execute();
	unset($query);

	// Очищаем таблицу hits
	$query = $db->getQuery(true);
	$query->delete($db->quoteName('#__js_res_hits'));
	$query->where('record_id='.$item->id);
	$db->setQuery($query);
	$result = $db->execute();
	unset($query);

	// Заменить section_id в таблице files
	//$db = JFactory::getDbo();
	$db->setQuery("UPDATE #__js_res_files SET section_id={$section_accessories_id}, type_id={$type_accessories_id},field_id={$field_image_accessories_id}
 		WHERE record_id = {$item->id}");
	$db->execute();

	$str .= ' / перемещено';
	$app->enqueueMessage($str);
	fwrite($file_handle, $str . "\n");
}

fwrite($file_handle, 'Успешно завершено' . "\n");
fclose($file_handle);
$app->enqueueMessage('B0 move to Accessories - Успешно завершено');

function writeLog($file_handle, $string)
{
	fwrite($file_handle, $string . " \n");
}

function setFields(object $record): array
{
	$fields = json_decode($record->fields, TRUE);
	$newFields = [
		AccessoryIds::ID_SUBTITLE => $fields[SparepartIds::ID_SUBTITLE] ?? '',
		AccessoryIds::ID_SEARCH_SYNONYMS => $fields[SparepartIds::ID_SEARCH_SYNONYMS] ?? '',
		AccessoryIds::ID_MANUFACTURER => $fields[SparepartIds::ID_MANUFACTURER],
		AccessoryIds::ID_IMAGE => $fields[SparepartIds::ID_IMAGE] ?? null,
		// Codes
		AccessoryIds::ID_PRODUCT_CODE => $fields[SparepartIds::ID_PRODUCT_CODE] ?? '',
		AccessoryIds::ID_VENDOR_CODE => $fields[SparepartIds::ID_VENDOR_CODE] ?? '',
		AccessoryIds::ID_ORIGINAL_CODE => $fields[SparepartIds::ID_ORIGINAL_CODE] ?? '',
		//*** Prices
		AccessoryIds::ID_PRICE_GENERAL => $fields[SparepartIds::ID_PRICE_GENERAL] ?? 0,
		AccessoryIds::ID_PRICE_SIMPLE => $fields[SparepartIds::ID_PRICE_SIMPLE] ?? 0,
		AccessoryIds::ID_PRICE_SILVER => $fields[SparepartIds::ID_PRICE_SILVER] ?? 0,
		AccessoryIds::ID_PRICE_GOLD => $fields[SparepartIds::ID_PRICE_GOLD] ?? 0,
		AccessoryIds::ID_PRICE_DELIVERY => $fields[SparepartIds::ID_PRICE_DELIVERY] ?? 0,
		AccessoryIds::ID_IS_SPECIAL => $fields[SparepartIds::ID_IS_SPECIAL] ?? -1,
		AccessoryIds::ID_PRICE_SPECIAL => $fields[SparepartIds::ID_PRICE_SPECIAL] ?? 0,
		AccessoryIds::ID_IS_ORIGINAL => $fields[SparepartIds::ID_IS_ORIGINAL] ?? -1,
		AccessoryIds::ID_IS_BY_ORDER => $fields[SparepartIds::ID_IS_BY_ORDER] ?? -1,
		//*** Availability
		AccessoryIds::ID_SEDOVA => $fields[SparepartIds::ID_SEDOVA] ?? 0,
		AccessoryIds::ID_KHIMIKOV => $fields[SparepartIds::ID_KHIMIKOV] ?? 0,
		AccessoryIds::ID_ZHUKOVA => $fields[SparepartIds::ID_ZHUKOVA] ?? 0,
		AccessoryIds::ID_KULTURY => $fields[SparepartIds::ID_KULTURY] ?? 0,
		AccessoryIds::ID_SHKOLNAYA => $fields[SparepartIds::ID_SHKOLNAYA] ?? 0,
		//***
		AccessoryIds::ID_CHARACTERISTICS => $fields[SparepartIds::ID_CHARACTERISTICS] ?? null,
		AccessoryIds::ID_DESCRIPTION => $fields[SparepartIds::ID_DESCRIPTION] ?? null,
		AccessoryIds::ID_GALLERY => $fields[SparepartIds::ID_GALLERY] ?? null,
		AccessoryIds::ID_VIDEO => $fields[SparepartIds::ID_VIDEO] ?? null,
		//*** Filters
		AccessoryIds::ID_MODEL => setModels($fields[SparepartIds::ID_MODEL]),
		//AccessoryIds::ID_MODEL => $fields[SparepartIds::ID_MODEL],
		AccessoryIds::ID_YEAR => $fields[SparepartIds::ID_YEAR],
		AccessoryIds::ID_MOTOR => $fields[SparepartIds::ID_MOTOR],
		AccessoryIds::ID_DRIVE => $fields[SparepartIds::ID_DRIVE],
		//*** Relations
		AccessoryIds::ID_ANALOGS => $fields[SparepartIds::ID_ANALOGS] ?? null,
		AccessoryIds::ID_ASSOCIATED => $fields[SparepartIds::ID_ASSOCIATED] ?? null,
		AccessoryIds::ID_WORKS => $fields[SparepartIds::ID_WORKS] ?? null,
	];
	return $newFields;
}

function setModels(array $models): array
{
	$newModels = [];
	foreach ($models as $model) {
		switch ($model) {
			case 'Logan':
				$newModels[] = 'Logan';
				break;
			case 'Logan II':
				$newModels[] = 'Logan 2';
				break;
			case 'Sandero':
				$newModels[] = 'Sandero';
				break;
			case 'Sandero II':
				$newModels[] = 'Sandero 2';
				break;
			case 'Sandero Stepway':
				$newModels[] = 'Sandero Stepway';
				break;
			case 'Sandero Stepway II':
				$newModels[] = 'Sandero Stepway 2';
				break;
			case 'Duster':
				$newModels[] = 'Duster';
				break;
			case 'Duster II':
				$newModels[] = 'Duster 2';
				break;
			case 'Kaptur':
				$newModels[] = 'Kaptur';
				break;
			case 'Dokker':
				$newModels[] = 'Dokker';
				break;
			case 'Arkana':
				$newModels[] = 'Arkana';
				break;
		}
	}
	//b0dd($newModels);
	return $newModels;
}
function setCategories(array $models): array
{
	$categories = [];
	foreach ($models as $model) {
		switch ($model) {
			case 'Logan':
				$categories[AccessoryIds::ID_CATEGORY_LOGAN] = $model;
				break;
			case 'Logan 2':
				$categories[AccessoryIds::ID_CATEGORY_LOGAN_2] = $model;
				break;
			case 'Sandero':
				$categories[AccessoryIds::ID_CATEGORY_SANDERO] = $model;
				break;
			case 'Sandero 2':
				$categories[AccessoryIds::ID_CATEGORY_SANDERO_2] = $model;
				break;
			case 'Sandero Stepway':
				$categories[AccessoryIds::ID_CATEGORY_SANDERO_STEPWAY] = $model;
				break;
			case 'Sandero Stepway 2':
				$categories[AccessoryIds::ID_CATEGORY_SANDERO_STEPWAY_2] = $model;
				break;
			case 'Duster':
				$categories[AccessoryIds::ID_CATEGORY_DUSTER] = $model;
				break;
			case 'Duster 2':
				$categories[AccessoryIds::ID_CATEGORY_DUSTER_2] = $model;
				break;
			case 'Kaptur':
				$categories[AccessoryIds::ID_CATEGORY_KAPTUR] = $model;
				break;
			case 'Dokker':
				$categories[AccessoryIds::ID_CATEGORY_DOKKER] = $model;
				break;
			case 'Arkana':
				$categories[AccessoryIds::ID_CATEGORY_ARKANA] = $model;
				break;
		}
		if (count($categories) == 9) {
			$categories = [];
			$categories[AccessoryIds::ID_CATEGORY_UNIVERSAL] = 'Универсальные';
		}
	}
	return $categories;
}




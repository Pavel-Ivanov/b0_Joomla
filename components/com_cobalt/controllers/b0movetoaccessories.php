<?php
JImport('b0.Sparepart.SparepartKeys');
JImport('b0.Sparepart.SparepartIds');
//JImport('b0.Accessory.AccessoryKeys');
JImport('b0.Accessory.AccessoryIds');

JImport('b0.fixtures');
require_once JPATH_ROOT . '/components/com_cobalt/api.php';

class CobaltControllerB0MoveToAccessories extends JControllerLegacy
{
	protected $log_file_path = "/logs/b0_move_to_accessories.txt";
	protected $log_file_handle;
	protected $logs = [];

	protected  $fields;
	protected  $models;
	protected  $categories;

	// Вызов /index.php?option=com_cobalt&task=b0movetoaccessories.move&id=.....
	public function move()
	{
		$id = $this->input->get('id', 0);
		$record = JTable::getInstance('Record', 'CobaltTable');
		$record->load($id);
		$record->section_id = AccessoryIds::ID_SECTION;
		$record->type_id = AccessoryIds::ID_TYPE;

		$this->fields = $this->setFields($record);
		$record->fields = json_encode($this->fields);
		//b0dd($this->fields);
		$this->categories = $this->setCategories($record);
		$record->categories = json_encode($this->categories);
		//b0debug($record);
		$result = $record->store();
		b0debug($result);

		// Запись в record_values

		// Запись в record_category
		foreach ($this->categories as $key => $category) {
			$tableCategory = JTable::getInstance('Record_category', 'CobaltTable');
			$categoryData = [
				'catid' => (int) $key,
				'record_id' => (int) $id,
				'ordering' => 0,
				'otime' => null,
				'section_id' => (int) AccessoryIds::ID_SECTION,
				'published' => 1,
				'access' => 1,
			];
			$tableCategory->bind($categoryData);
			$tableCategory->store();
		}

		// Заменить section_id в таблицах
		$db = JFactory::getDbo();
		$db->setQuery("UPDATE #__js_res_files SET section_id='12',type_id='14',field_id='152' WHERE record_id = {$id}");
		$db->execute();
	}

	private function validateInput()
	{

	}

	private function setData(object $record):array
	{
		$data = [
			'title' => $record->title,
			'published' => '1',
			'access' => '1',
			'params' => '',
			'hits'=> $record->hits,
			'meta_descr' => $record->meta_descr,
			'fieldsdata' => $record->fieldsdata,
		];
		return $data;

	}

	private function setFields(object $record)
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
			AccessoryIds::ID_MODEL => $this->setModels($record),
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

	private function setModels(object $record)
	{
		$newModels = [];
		$fields = json_decode($record->fields, TRUE);
		$models = $fields[SparepartIds::ID_MODEL];
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Logan')!== false) {
				$newModels[] = 'Logan';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Sandero')!== false) {
				$newModels[] = 'Sandero';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Duster')!== false) {
				$newModels[] = 'Duster';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Kaptur')!== false) {
				$newModels[] = 'Kaptur';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Dokker')!== false) {
				$newModels[] = 'Dokker';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Arkana')!== false) {
				$newModels[] = 'Arkana';
				break;
			}
		}
		return $newModels;
	}

	private function setCategories(object $record)
	{
		//$categories = json_decode($record->categories, TRUE);
		$categories = [];
		$fields = json_decode($record->fields, TRUE);
		$models = $fields[AccessoryIds::ID_MODEL];
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Logan')!== false) {
				$categories['175'] = 'Logan';
				//$categories[] = '175';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Sandero')!== false) {
				$categories['176'] = 'Sandero';
				//$categories[] = '176';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Duster')!== false) {
				$categories['177'] = 'Duster';
				//$categories[] = '177';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Kaptur')!== false) {
				$categories['178'] = 'Kaptur';
				//$categories[] = '178';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Dokker')!== false) {
				$categories['179'] = 'Dokker';
				//$categories[] = '179';
				break;
			}
		}
		foreach ($models as $key=>$model) {
			if (strpos($model, 'Arkana')!== false) {
				$categories['180'] = 'Arkana';
				//$categories[] = '180';
				break;
			}
		}
		return $categories;
	}

	private  function clear (object $record) {
		$record_id = $record->id;
		$record_type = $record->type_id;
		$type = ItemsStore::getType($record_type);

		$db = JFactory::getDbo();

		$db->setQuery("DELETE FROM #__js_res_tags_history WHERE record_id = " . $record_id);
		$db->execute();

		$db->setQuery("SELECT * FROM #__js_res_files WHERE record_id = " . $record_id);
		$files = $db->loadObjectList('id');

		if(!empty($files) && !$type->params->get('audit.versioning'))
		{
			$field_table   = JTable::getInstance('Field', 'CobaltTable');
			$cobalt_params = JComponentHelper::getParams('com_cobalt');

			foreach($files AS $file)
			{
				$field_table->load($file->field_id);
				$field_params = new JRegistry($field_table->params);
				$subfolder    = $field_params->get('params.subfolder', $field_table->field_type);
				if(JFile::exists(JPATH_ROOT . DIRECTORY_SEPARATOR . $cobalt_params->get('general_upload') . DIRECTORY_SEPARATOR . $subfolder . DIRECTORY_SEPARATOR . $file->fullpath))
				{
					unlink(JPATH_ROOT . DIRECTORY_SEPARATOR . $cobalt_params->get('general_upload') . DIRECTORY_SEPARATOR . $subfolder . DIRECTORY_SEPARATOR . $file->fullpath);
				}
				// deleting image field files
				elseif(JFile::exists(JPATH_ROOT . DIRECTORY_SEPARATOR . $file->fullpath))
				{
					unlink(JPATH_ROOT . DIRECTORY_SEPARATOR . $file->fullpath);
				}
			}
			$db->setQuery("DELETE FROM #__js_res_files WHERE id IN (" . implode(',', array_keys($files)) . ")");
			$db->execute();
		}

		$db->setQuery("DELETE FROM #__js_res_vote WHERE (ref_id = " . $record_id .
			" AND ref_type = 'record') OR (ref_id IN(SELECT id FROM #__js_res_comments WHERE record_id = " . $record_id . ") AND ref_type = 'comment')");
		$db->execute();

		$db->setQuery("DELETE FROM #__js_res_comments WHERE record_id = " . $record_id);
		$db->execute();

		$db->setQuery("DELETE FROM #__js_res_favorite WHERE record_id = " . $record_id);
		$db->execute();

		$db->setQuery("DELETE FROM #__js_res_hits WHERE record_id = " . $record_id);
		$db->execute();

		$db->setQuery("DELETE FROM #__js_res_subscribe WHERE type = 'record' AND ref_id = " . $record_id);
		$db->execute();

		$db->setQuery("DELETE FROM #__js_res_notifications WHERE ref_1 = " . $record_id);
		$db->execute();

//		$db->setQuery("DELETE FROM #__js_res_record WHERE parent = 'com_cobalt' AND parent_id = " . $record_id);
//		$db->execute();

//		$db->setQuery("DELETE FROM #__js_res_record WHERE parent = 'com_cobalt' AND id = " . $record_id);
//		$db->execute();

//		ATlog::log($record, ATlog::REC_DELETE);
//
//		JPluginHelper::importPlugin('mint');
//		$dispatcher = JEventDispatcher::getInstance();
//		$dispatcher->trigger('onRecordDelete', array($record));

		return TRUE;
	}

}
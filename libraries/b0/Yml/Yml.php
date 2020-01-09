<?php
defined('_JEXEC') or die();
JImport('b0.Yml.YmlOffer');
JImport('b0.Yml.YmlConfig');
JImport('b0.Sparepart.SparepartIds');
JImport('b0.Accessory.AccessoryIds');
JImport('b0.fixtures');
/**
 * Class Yml
 *
 */
class Yml
{
	private $logs = [];
	
	// Разделы файла
	public $name;
	public $company;
	public $url;
	public $currency;
	public $currencyRate;
	public $categories;
	public $deliveryOptions;
	public $offers;
	
	public function __construct()
	{
		$this->name            = YmlConfig::YML_NAME;
		$this->company         = YmlConfig::YML_COMPANY;
		$this->url             = YmlConfig::YML_URL;
		$this->currency        = YmlConfig::YML_CURRENCY;
		$this->currencyRate    = YmlConfig::YML_CURRENCY_RATE;
		$this->categories      = $this->setCategories();
		$this->deliveryOptions = YmlConfig::YML_DELIVERY_OPTIONS;
		$this->offers          = $this->setOffers();
	}
	
	// Создает массив категорий
	private function setCategories():array
	{
		$categories = [];
		$ymlFieldId = YmlConfig::YML_FIELD_ID;
		/* получаем записи из БД */
		$db    = JFactory::getDbo();
		$query = "SELECT id, name, parent_id FROM #__js_res_field_multilevelselect WHERE field_id=" . $ymlFieldId;
		$db->setQuery($query);
		$list = $db->loadObjectList();
		$categories['1'] = [
			'name' => 'Авто',
		];
		foreach ($list as $item) {
			$categories[$item->id] = [
				'name' => $item->name,
				'parent' => $item->parent_id
			];
		}
		return $categories;
	}
	
	// Создает массив товаров
	private function setOffers(): array
	{
		$offers              = [];
		$sectionSparepartsId = SparepartIds::ID_SECTION;
		$sectionAccessoryId  = AccessoryIds::ID_SECTION;
		
		/* получаем записи из БД */
		$list = $this->getItems();
		if (!$list) {
			$this->logs[] = 'Ошибка запроса к базе данных';
			return [];
		}
		/* цикл по записям БД */
		foreach ($list as $item) {
			$fields = json_decode($item->fields, TRUE);
/*			if (!$this->isYmUploadEnable($item)) {
				continue;
			}*/
			if ($this->isByOrder($item)) {
				continue;
			}
			$offers[] = new YmlOffer($item, $this->categories);
		}
//		b0dd($offers);
		return $offers;
	}
	
	private function getItems()
	{
		$sectionSparepartsId = SparepartIds::ID_SECTION;
		$sectionAccessoryId  = AccessoryIds::ID_SECTION;
		/* получаем записи из БД */
		$db    = JFactory::getDbo();
		$query = "SELECT id, title, section_id, meta_descr, alias, categories, fields FROM #__js_res_record
				WHERE (section_id IN ($sectionSparepartsId, $sectionAccessoryId) AND published = 1)";
		if (YmlConfig::YML_ITEMS_LIMIT > 0) {
			$query .= " LIMIT 0," . YmlConfig::YML_ITEMS_LIMIT;
		}
		$db->setQuery($query);
		return $db->loadObjectList();
	}
	
	private function isByOrder($item): bool
	{
		$fields = json_decode($item->fields, TRUE);
		switch ($item->section_id) {
			case SparepartIds::ID_SECTION:
				return $fields[SparepartIds::ID_IS_BY_ORDER] == 1 ? true : false;
				break;
			case AccessoryIds::ID_SECTION:
				return $fields[AccessoryIds::ID_IS_BY_ORDER] == 1 ? true : false;
				break;
			default:
				return false;
		}
	}
	
	private function getHead() :string
	{
		$head =
			'<?xml version="1.0" encoding="UTF-8"?>' . "\n" .
			'<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . "\n" .
			'<yml_catalog date="' . date("Y-m-d H:i") . '">' . "\n" .
			'<shop>' . "\n" .
			'<name>' . YmlConfig::YML_NAME . '</name>' . "\n" .
			'<company>' . YmlConfig::YML_COMPANY . '</company>' . "\n" .
			'<url>' . YmlConfig::YML_URL . '</url>' . "\n" .
			'<currencies>' . "\n" .
			'<currency id="' . YmlConfig::YML_CURRENCY . '" rate="' . YmlConfig::YML_CURRENCY_RATE . '"/>' . "\n" .
			'</currencies>' . "\n" .
			'<categories>' . "\n";
		foreach ($this->categories as $id => $category) {
			if ($category['name']) {
				$string = '<category id="' . $id . '"';
				if (isset($category['parent'])) {
					$string .= ' parentId="' . $category['parent'] . '"';
				}
				$string .= '>' . $category['name'] . '</category>' . "\n";
				$head  .= $string;
			}
		}
		$head .= '</categories>' . "\n";
		$head .= '<delivery-options>' . "\n";
		foreach (YmlConfig::YML_DELIVERY_OPTIONS as $option) {
			$head .= '<option cost="' . $option['cost'] . '" days="' . $option['days'] . '"/>' . "\n";
		}
		$head .= '</delivery-options>' . "\n";
		$head .= '<offers>' . "\n";
		return $head;
	}
	
	private function getFooter() :string
	{
		$footer = "</offers>\n";
		$footer.= "</shop>\n";
		$footer.= "</yml_catalog>";
		return $footer;
	}
	
	public function renderYMarketFile ()
	{
		// Открываем основной файл
		/** @var mixed $handle */
		$yMarketFileHandle = fopen(JPATH_ROOT . YmlConfig::YML_YMARKET_FILE_PATH, "w+t");
		if ($yMarketFileHandle == false) {
			$logs[] = 'Ошибка открытия файла Yandex Market';
			return false;
		}
		
		// Записываем шапку
		/** @var string $head */
		$head = $this->getHead();
		$res  = fwrite($yMarketFileHandle, $head);
		if ($res == false) {
			$logs[] = 'Ошибка записи в файл Yandex Market';
			fclose($yMarketFileHandle);
			return false;
		}
		foreach ($this->offers as $offer) {
			if (!$offer->isYmUploadEnable) {
				continue;
			}
			$content = $offer->renderOffer();
			$res     = fwrite($yMarketFileHandle, $content);
			if ($res == false) {
				$logs[] = 'Ошибка записи в файл Yandex Market';
				fclose($yMarketFileHandle);
				return false;
			}
		}
		
		/** @var string $footer */
		$footer = $this->getFooter();
		fwrite($yMarketFileHandle, $footer);
		fclose($yMarketFileHandle);
		$logs[] = 'Файл Yandex Market сформирован';
		return true;
	}
	
	public function renderYFullFile()
	{
		// Открываем основной файл
		/** @var mixed $handle */
		$handle = fopen(JPATH_ROOT . YmlConfig::YML_YFULL_FILE_PATH, "w+t");
		if ($handle == false) {
			$logs[] = 'Ошибка открытия файла yml';
			return false;
		}
		
		$head = $this->getHead();
		$res = fwrite($handle, $head);
		if ($res == false) {
			$logs[] = 'Ошибка записи в файл yml';
			fclose($handle);
			return false;
		}
		
		foreach ($this->offers as $offer) {
			$content = $offer->renderOffer();
			$res     = fwrite($handle, $content);
			if ($res == false) {
				$logs[] = 'Ошибка записи в файл yml';
				fclose($handle);
				return false;
			}
		}
		
		/** @var string $footer */
		$footer = $this->getFooter();
		fwrite($handle, $footer);
		fclose($handle);
		$logs[] = 'Файл yml сформирован';
		return true;
	}
}
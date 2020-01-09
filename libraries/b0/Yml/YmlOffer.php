<?php
defined('_JEXEC') or die();

JImport('b0.Yml.YmlConfig');
JImport('b0.Sparepart.SparepartIds');
//JImport('b0.Sparepart.SparepartKeys');
JImport('b0.Accessory.AccessoryIds');
//JImport('b0.Accessory.AccessoryKeys');
JImport('b0.fixtures');

/**
 * Class YmlOffer
 *  Создает один Offer
 */
class YmlOffer
{
	private const BASE_URL = 'https://logan-shop.spb.ru/';
	private const BASE_URL_SPAREPARTS = self::BASE_URL . 'spareparts/item/';
	private const BASE_URL_ACCESSORIES = self::BASE_URL . 'accessories/item/';
	private const PAYMENT_OPTIONS = 'Наличные, Visa/Mastercard.';
	//private const PAYMENT_OPTIONS = 'Наличные.';
	
	private const LIMIT_DELIVERY_CITY = 500;
	private const PRICE_DELIVERY_CITY = 300;
	private const DAYS = '1-2';
//	private const LIMIT_DELIVERY_SATELLITES = 1500;
//	private const PRICE_DELIVERY_SATELLITES = 500;
	
	
	private $id;
	private $sectionId;
	private $categoryId;
	private $fields;
	private $alias;
	private $name;
	private $description;
	private $priceGeneral;
	private $priceSpecial;
	private $isSpecial;
	private $manufacturer;
	private $vendor;
	private $vendorCode;
	private $country;
	private $imageUrl;
	private $params;
	public $isYmUploadEnable;
	
	/**
	 * YmlOffer constructor.
	 * Конструктор класса
	 *
	 * @param object $item
	 */
	public function __construct($item, $categories)
	{
		$this->id = $item->id;
		$this->sectionId = $item->section_id;
		//TODO сделать Id категории
		$this->categoryId = $this->getCategoryId($item, $categories);
		$this->fields = json_decode($item->fields, TRUE);
		$this->alias = $item->alias;
		$this->name = $item->title;
		$this->description = $this->getDescription($item);
		$this->priceGeneral = $this->getPriceGeneral();
		$this->priceSpecial = $this->getPriceSpecial();
		$this->isSpecial = $this->getIsSpecial();
		$this->manufacturer = $this->getManufacturer();
		$this->vendor = $this->getVendor();
		$this->vendorCode = $this->getVendorCode();
		$this->country = $this->getCountry();
		$this->imageUrl = $this->getImageUrl();
		$this->params = $this->getParams();
		$this->isYmUploadEnable = $this->getIsYmUploadEnable();
	}
	
	/**
	 * @param $item
	 * @param $categories
	 *
	 * @return bool|false|int|string
	 *
	 * @since version
	 */
	private function getCategoryId($item, $categories)
	{
		$fields = json_decode($item->fields, TRUE);
		if ($item->section_id == SparepartIds::ID_SECTION) {
			if (!isset($fields[SparepartIds::ID_YM_CATEGORY]) OR $fields[SparepartIds::ID_YM_CATEGORY] == null) {
				return 1;
			}
			$cats = array_shift($fields[SparepartIds::ID_YM_CATEGORY]);
			$categoryName = end($cats);
			// Ищем по названию категории
			foreach ($categories as $key => $category) {
				if ($category['name'] === $categoryName) {
					return $key;
				}
			}
			return 1;
		}
		elseif ($item->section_id == AccessoryIds::ID_SECTION) {
			if (!isset($fields[AccessoryIds::ID_YM_CATEGORY]) OR $fields[AccessoryIds::ID_YM_CATEGORY] == null) {
				return 1;
			}
			$cats = array_shift($fields[AccessoryIds::ID_YM_CATEGORY]);
			$categoryName = end($cats);
			// Ищем по названию категории
			foreach ($categories as $key => $category) {
				if ($category['name'] === $categoryName) {
					return $key;
				}
			}
			return 1;
		}
	}
	
	private function getDescription($item)
	{
		$description = '';
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				$description = '<![CDATA[';
				$description .= '<p>' . $item->title . ' для ' . implode(', ', $this->fields[SparepartIds::ID_MODEL]) . '.</p>';
				$description .= isset($this->fields[SparepartIds::ID_DESCRIPTION]) ? str_ireplace('&nbsp;','',$this->fields[SparepartIds::ID_DESCRIPTION]) : '';
				$description .= ']]>';
				return $description;
				break;
			case AccessoryIds::ID_SECTION:
				$description = '<![CDATA[';
				$description .= '<p>' . $item->title . ' для ' . implode(', ', $this->fields[AccessoryIds::ID_MODEL]) . '.</p>';
				$description .= isset($this->fields[AccessoryIds::ID_DESCRIPTION]) ? str_ireplace('&nbsp;','',$this->fields[AccessoryIds::ID_DESCRIPTION]) : '';
				$description .= ']]>';
				return $description;
				break;
			default:
				return '';
		}
	}
	
	/**
	 * @return int|null
	 * Возвращает Цену обычную
	 */
	private function getPriceGeneral(): ?string
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				return $this->fields[SparepartIds::ID_PRICE_GENERAL];
				break;
			case AccessoryIds::ID_SECTION:
				return $this->fields[AccessoryIds::ID_PRICE_GENERAL];
				break;
			default:
				return '';
		}
	}
	
	/**
	 * @return int|null
	 * Возвращает Цену Спецпредложения
	 */
	private function getPriceSpecial(): ?string
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				return $this->fields[SparepartIds::ID_PRICE_SPECIAL];
				break;
			case AccessoryIds::ID_SECTION:
				return $this->fields[AccessoryIds::ID_PRICE_SPECIAL];
				break;
			default:
				return '';
		}
	}
	
	/**
	 * @return bool
	 * Возвращает признак Спецпредложения
	 */
	private function getIsSpecial():bool
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				return $this->fields[SparepartIds::ID_IS_SPECIAL] == 1 ? true : false;
				break;
			case AccessoryIds::ID_SECTION:
				return $this->fields[AccessoryIds::ID_IS_SPECIAL] == 1 ? true : false;
				break;
			default:
				return false;
		}
	}
	
	/**
	 * @return string
	 * Возвращает строку Производитель / Страна
	 */
	private function getManufacturer() :string
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				return $this->fields[SparepartIds::ID_MANUFACTURER][0];
				break;
			case AccessoryIds::ID_SECTION:
				return $this->fields[AccessoryIds::ID_MANUFACTURER][0];
				break;
			default:
				return '';
		}
	}
	
	/**
	 * @return string
	 * Возвращает название Производителя
	 */
	private function getVendor() :string
	{
		$pos = stripos($this->manufacturer, '/');
		$vendor = trim(substr($this->manufacturer, 0, $pos));
		$country = trim(substr($this->manufacturer, ++$pos));
		if (!$vendor) {$vendor = $country;}
		return $vendor;
	}
	
	/**
	 * @return string
	 * Возвращает код производителя
	 */
	private function getVendorCode() :string
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				return $this->fields[SparepartIds::ID_VENDOR_CODE];
				break;
			case AccessoryIds::ID_SECTION:
				return $this->fields[AccessoryIds::ID_VENDOR_CODE];
				break;
			default:
				return '';
		}
	}
	
	/**
	 * @return string
	 * Возвращает название Страны производства
	 */
	private function getCountry() :string
	{
		$pos = stripos($this->manufacturer, '/');
		return trim(substr($this->manufacturer, ++$pos));
	}
	
	/**
	 * @return string
	 * Возвращает ссылку на изображение
	 */
	private function getImageUrl() :string
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				if (isset($this->fields[SparepartIds::ID_YM_IMAGE])) {
					return $this->fields[SparepartIds::ID_YM_IMAGE]['image'] ?? '';
				}
				else {
					return $this->fields[SparepartIds::ID_IMAGE]['image'] ?? '';
				}
				break;
			case AccessoryIds::ID_SECTION:
				if (isset($this->fields[AccessoryIds::ID_YM_IMAGE])) {
					return $this->fields[AccessoryIds::ID_YM_IMAGE]['image'] ?? '';
				}
				else {
					return $this->fields[AccessoryIds::ID_IMAGE]['image'] ?? '';
				}
				break;
			default:
				return '';
		}
	}
	
	private function getParams():array
	{
		$params = [];
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				$params['models'] = $this->fields[SparepartIds::ID_MODEL];
				$params['motors'] = $this->fields[SparepartIds::ID_MOTOR];
				$params['years'] = $this->fields[SparepartIds::ID_YEAR];
				return $params;
				break;
			case AccessoryIds::ID_SECTION:
				$params['models'] = $this->fields[AccessoryIds::ID_MODEL];
				$params['motors'] = $this->fields[AccessoryIds::ID_MOTOR];
				$params['years'] = $this->fields[AccessoryIds::ID_YEAR];
				return $params;
				break;
			default:
				return $params;
		}
	}
	
	private function getIsYmUploadEnable(): bool
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				if (isset($this->fields[SparepartIds::ID_YM_UPLOAD_ENABLE])) {
					return $this->fields[SparepartIds::ID_YM_UPLOAD_ENABLE] == 1 ? true : false;
				}
				else {
					return false;
				}
				break;
			case AccessoryIds::ID_SECTION:
				if (isset($this->fields[AccessoryIds::ID_YM_UPLOAD_ENABLE])) {
					return $this->fields[AccessoryIds::ID_YM_UPLOAD_ENABLE] == 1 ? true : false;
				}
				else {
					return false;
				}
				break;
			default:
				return false;
		}
	}
	
	/**
	 * @return string
	 *
	 */
	public function renderOffer() :string
	{
		$content = '';
		//$content .= $this->renderOfferId();
		$content .= '<offer id="' . $this->id . '" available="true">' . "\n";
		$content .= $this->renderUrl();
		$content .=	$this->renderPrice();
		$content .= $this->renderOldPrice();
		$content .= $this->renderSalesNotes();
		$content .= $this->renderAge();
		$content .= $this->renderCurrencyId();
		$content .= $this->renderCategoryId();
		$content .= $this->renderPicture();
		$content .= $this->renderStore();
		$content .= $this->renderPickup();
		$content .= $this->renderDelivery();
		$content .= $this->renderDeliveryOptions();
		$content .= $this->renderNameYml();
		$content .= $this->renderDescription();
		$content .= $this->renderVendor();
		$content .= $this->renderVendorCode();
		$content .= $this->renderVendorModel();
		$content .= $this->renderManufacturerWarranty();
		$content .= $this->renderCountryOfOrigin();
		$content .= $this->renderParams();
		$content .= '</offer>' . "\n";
		return $content;
	}
	
	private  function renderUrl():string
	{
		switch ($this->sectionId) {
			case SparepartIds::ID_SECTION:
				return '<url>' . self::BASE_URL_SPAREPARTS . $this->id . '-' . $this->alias . '</url>' . "\n";
				break;
			case AccessoryIds::ID_SECTION:
				return '<url>' . self::BASE_URL_ACCESSORIES . $this->id . '-' . $this->alias . '</url>' . "\n";
				break;
			default:
				return '';
		}
	}

	private  function renderPrice():string
	{
		$price = ($this->isSpecial == '1') ? $this->priceSpecial : $this->priceGeneral;
		return '<price>'.$price.'.00</price>' . "\n";
	}
	
	private  function renderOldPrice():string
	{
		if ($this->isSpecial == '0') {
			return '';
		}
		return '<oldprice>'.$this->priceGeneral.'.00</oldprice>' . "\n";
	}
	
	private  function renderSalesNotes ()
	{
		$message = '<sales_notes>' . self::PAYMENT_OPTIONS . '</sales_notes>' . "\n";
		
		return $message;
	}
	
	private  function renderAge () {
		return '<age>0</age>' . "\n";
	}
	
	private  function renderCurrencyId () {
		return '<currencyId>RUR</currencyId>' . "\n";
	}
	
	private  function renderCategoryId () {
		return '<categoryId>'.$this->categoryId.'</categoryId>' . "\n";
	}
	
	private  function renderPicture () {
		return '<picture>'.self::BASE_URL.$this->imageUrl.'</picture>' . "\n";
	}
	
	private  function renderStore () {
		return '<store>true</store>' . "\n";
	}
	
	private  function renderPickup () {
		return '<pickup>true</pickup>' . "\n";
	}
	
	private  function renderDelivery () {
		return '<delivery>true</delivery>' . "\n";
	}
	
	private  function renderDeliveryOptions () {
		$price = ($this->isSpecial) ? $this->priceSpecial : $this->priceGeneral;
		if ($price >= self::LIMIT_DELIVERY_CITY) {
			return '';
		}
		$str = '<delivery-options>' . "\n";
		$str .= '<option cost="'.self::PRICE_DELIVERY_CITY.'" days="'.self::DAYS.'"/>' . "\n";
		$str .= '</delivery-options>' . "\n";
		return $str;
	}
	
	private  function renderNameYml () {
		return '<name>'.$this->name.'</name>' . "\n";
	}
	
	private  function renderDescription () {
		return '<description>'.$this->description.'</description>' . "\n";
	}
	
	private  function renderVendor():string
	{
		return '<vendor>'.$this->vendor.'</vendor>' . "\n";
	}
	
	private  function renderVendorCode():string
	{
		if ($this->vendorCode == '') {
			return '';
		}
		return '<vendorCode>'.$this->vendorCode.'</vendorCode>' . "\n";
	}
	
	private  function renderVendorModel():string
	{
		if ($this->vendorCode == '') {
			return '';
		}
		return '<model>'.$this->vendorCode.'</model>' . "\n";
	}
	
	private  function renderManufacturerWarranty():string
	{
		return '<manufacturer_warranty>true</manufacturer_warranty>' . "\n";
	}
	
	private  function renderCountryOfOrigin():string
	{
		return '<country_of_origin>'.$this->country.'</country_of_origin>' . "\n";
	}
	
	private function renderParams():string
	{
		$paramsStr = '';
		if (isset($this->params['models'])){
			foreach ($this->params['models'] as $model){
				$paramsStr .= '<param name="Марка автомобиля">' . $model . '</param>' . "\n";
			}
		}
		if (isset($this->params['motors'])){
			foreach ($this->params['motors'] as $motor){
				$paramsStr .= '<param name="Мотор автомобиля">' . $motor . '</param>' . "\n";
			}
		}
		if (isset($this->params['years'])){
			foreach ($this->params['years'] as $year){
				$paramsStr .= '<param name="Год выпуска автомобиля">' . $year . '</param>' . "\n";
			}
		}
		return $paramsStr;
	}
}

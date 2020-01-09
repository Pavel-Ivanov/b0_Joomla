<?php
defined('_JEXEC') or die();
//JImport('b0.Cart.Cart');
JImport('b0.Cart.CartItem');
JImport('b0.Sparepart.SparepartIds');
JImport('b0.Sparepart.SparepartKeys');
JImport('b0.Accessory.AccessoryIds');
JImport('b0.fixtures');

class CartItem
{
	protected const ICON_RUB = '<i class="uk-icon-rub uk-text-muted"></i>';

	public $id;
	public $title;
	public $subTitle;
	public $url;
	public $image;
	public $productCode;
	public $isSpecial;
	public $priceDelivery;
	public $costDelivery;
	public $quantity;

	public function __construct($item)
	{
		// Поля в $item -> id, title, alias, fields
		$fields = json_decode($item->fields, TRUE);
		$cartSession = JFactory::getApplication()->getUserState('cart');
		//b0debug($fields);
		$this->id = $item->id;
		$this->title = $item->title;
		//$this->subTitle = $fields[SparepartIds::ID_SUBTITLE];
		$this->subTitle = $this->setSubTitle($fields, $item->type_id);
		//$this->url = JRoute::_('/spareparts/item/'.$item->id.'-'.$item->alias);
		$this->url = $this->setUrl($item);
		//$this->image = $fields[SparepartIds::ID_IMAGE]['image'];
		$this->image = $this->setImage($fields, $item->type_id);
		//$this->productCode =  $fields[SparepartIds::ID_PRODUCT_CODE];
		$this->productCode =  $this->setProductCode($fields, $item->type_id);
		//$this->isSpecial = isset($fields[SparepartIds::ID_IS_SPECIAL]) && ($fields[SparepartIds::ID_IS_SPECIAL] == 1) ? true : false;
		$this->isSpecial = $this->setIsSpecial($fields, $item->type_id);
		//$this->priceDelivery = $fields[SparepartIds::ID_PRICE_DELIVERY];
		$this->priceDelivery = $this->setPriceDelivery($fields, $item->type_id);
		$this->quantity = $cartSession[$item->id]['quantity'];
		$this->costDelivery = $this->priceDelivery * $this->quantity;
	}

	private function setSubTitle($fields, $typeId):string
	{
		if ($typeId == SparepartIds::ID_TYPE) {
			return $fields[SparepartIds::ID_SUBTITLE];
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {
			return $fields[AccessoryIds::ID_SUBTITLE];
		}
		else {
			return '';
		}
	}

	private function setUrl($item):string
	{
		if ($item->type_id == SparepartIds::ID_TYPE) {
			return JRoute::_('/spareparts/item/'.$item->id.'-'.$item->alias);
		}
		elseif ($item->type_id == AccessoryIds::ID_TYPE) {
			return JRoute::_('/accessories/item/'.$item->id.'-'.$item->alias);
		}
		else {
			return '';
		}
	}

	private function setImage($fields, $typeId):string
	{
		if ($typeId == SparepartIds::ID_TYPE) {
			return $fields[SparepartIds::ID_IMAGE]['image'];
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {
			return $fields[AccessoryIds::ID_IMAGE]['image'];
		}
		else {
			return '';
		}
	}

	private function setProductCode($fields, $typeId):string
	{
		if ($typeId == SparepartIds::ID_TYPE) {
			return $fields[SparepartIds::ID_PRODUCT_CODE];
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {
			return $fields[AccessoryIds::ID_PRODUCT_CODE];
		}
		else {
			return '';
		}
	}

	private function setIsSpecial($fields, $typeId):bool
	{
		if ($typeId == SparepartIds::ID_TYPE) {
			return isset($fields[SparepartIds::ID_IS_SPECIAL]) && ($fields[SparepartIds::ID_IS_SPECIAL] == 1) ? true : false;
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {
			return isset($fields[AccessoryIds::ID_IS_SPECIAL]) && ($fields[AccessoryIds::ID_IS_SPECIAL] == 1) ? true : false;
		}
		else {
			return false;
		}
	}

	private function setPriceDelivery($fields, $typeId):string
	{
		if ($typeId == SparepartIds::ID_TYPE) {
			return $fields[SparepartIds::ID_PRICE_DELIVERY];
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {
			return $fields[AccessoryIds::ID_PRICE_DELIVERY];
		}
		else {
			return '';
		}
	}


	public function renderProductCode() {
		if (mb_strlen($this->productCode) == 0) {
			return;
		}
		echo '<p><strong>Код товара: </strong>' . $this->productCode;
		if ($this->isSpecial) {
			echo ' / <span class="uk-text-danger" data-uk-tooltip title="Скидки по дисконтным картам не действуют">спецпредложение</span></p>';
		}
	}

	public function renderPrice($price) {
		echo number_format($price, 0, '.', ' ') . ' ' . CartItem::ICON_RUB;
	}
}
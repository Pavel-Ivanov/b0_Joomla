<?php
defined('_JEXEC') or die();

JImport('b0.Sparepart.SparepartKeys');
JImport('b0.Company.CompanyConfig');
JImport('b0.pricehelper');
use Joomla\CMS\User\User;

class Spareparts
{
	public $items;
	
	/**
	 * Spareparts constructor.
	 *
	 * @param      $items
	 * @param User $user
	 */
	public function __construct($items)
	{
		$cart = JFactory::getApplication()->getUserState('cart') ?? array();
		$user = JFactory::getUser();
		foreach ($items as $item) {
//			$fields = $item->fields_by_key;
			$sparepart = new stdClass();
			$sparepart->id = $item->id;
			$sparepart->url = $item->url;
			$sparepart->title = $item->title;
			$sparepart->controls = $item->controls;
			$sparepart->image = $item->fields_by_key[SparepartKeys::KEY_IMAGE]->result ?? '';
			
			//Properties
			$sparepart->models = $item->fields_by_key[SparepartKeys::KEY_MODEL]->result ?? '';
			$sparepart->motors = $item->fields_by_key[SparepartKeys::KEY_MOTOR]->result ?? '';
			$sparepart->manufacturer = $item->fields_by_key[SparepartKeys::KEY_MANUFACTURER]->result ?? '';
			$sparepart->productCode = $item->fields_by_key[SparepartKeys::KEY_PRODUCT_CODE]->result ?? '';
			$sparepart->subtitle = $item->fields_by_key[SparepartKeys::KEY_SUBTITLE]->value ?? '';
			
			//Prices
			$sparepart->isSpecial = ($item->fields_by_key[SparepartKeys::KEY_IS_SPECIAL]->value == 1) ? true : false;
			$sparepart->isByOrder = ($item->fields_by_key[SparepartKeys::KEY_IS_BY_ORDER]->value == 1) ? true : false;
			$sparepart->isOriginal = ($item->fields_by_key[SparepartKeys::KEY_IS_ORIGINAL]->value == 1) ? true : false;
			$sparepart->isGeneral = (!$sparepart->isSpecial && !$sparepart->isByOrder) ? true : false;
			$sparepart->priceGeneral = $item->fields_by_key[SparepartKeys::KEY_PRICE_GENERAL]->value ?? 0;
			$sparepart->priceSpecial = $item->fields_by_key[SparepartKeys::KEY_PRICE_SPECIAL]->value ?? 0;
			$sparepart->priceDelivery = $item->fields_by_key[SparepartKeys::KEY_PRICE_DELIVERY]->value ?? 0;
			
			if (isset($item->fields_by_key[SparepartKeys::KEY_VENDOR_CODE])){
				if (in_array($this->getFieldViewRights($item->fields_by_key[SparepartKeys::KEY_VENDOR_CODE]), $user->getAuthorisedViewLevels())) {
					$sparepart->vendorCode = $item->fields_by_key[SparepartKeys::KEY_VENDOR_CODE]->value;
				}
				else {
					$sparepart->vendorCode = '';
				}
			}
			else {
				$sparepart->vendorCode = '';
			}
			
			$sparepart->isInCart = $this->isInCart($item->id, $cart);
			$sparepart->cartQuantity = $this->isInCart($item->id, $cart) ? (int) $cart[$item->id]['quantity'] : 0;
			
			$sparepart->yaCounter = CompanyConfig::COMPANY_YA_COUNTER;
			$sparepart->yaCounterGoal = CompanyConfig::COMPANY_YA_COUNTER_GOAL_SPAREPART;
			
			$this->items[$item->id] = $sparepart;
		}
	}
	
	/**
	 * @param $field
	 *
	 * @return string
	 */
	private function getFieldViewRights($field):string
	{
		return $field->params->get('core.field_view_access');
	}
	
	private function isInCart($id, $cart):bool
	{
		return array_key_exists($id, $cart);
	}
	
	/**
	 * @param object $item
	 */
	public function renderSubTitle(object $item)
	{
		if ($item->subtitle == '') {
			return;
		}
		echo '<p>'.$item->subtitle.'</p>';
	}
	
	/**
	 * @param string $tag
	 * @param string $label
	 * @param string $value
	 */
	public function renderField(string $tag, string $label, string $value)
	{
		if ($value == '') {
			return;
		}
		$str = '<'.$tag.'>';
		if ($label != '') {
			$str .= '<strong>' . $label .': </strong>';
		}
		$str .= $value;
		$str .= '</'.$tag.'>';
		echo $str;
	}
	
	/**
	 * @param object $item
	 */
	public function renderPrice(object $item)
	{
		if ($item->priceGeneral == 0) {
			return;
		}
		if ($item->isByOrder){
			echo '<p class="b0-price b0-price-general">Ожидается поступление</p>';
			echo '<p class="b0-price b0-price-general uk-text-muted">Цена уточняется при заказе</p>';
		}
        elseif ($item->isSpecial){
			echo '<p class="b0-price b0-price-special uk-text-danger">Специальная цена: ' . render_price($item->priceSpecial) . '</p>';
			echo '<p class="b0-price b0-price-general">Обычная цена: <del>' . render_price($item->priceGeneral) . '</del></p>';
			echo '<p>Вы экономите ' . render_economy($item->priceGeneral, $item->priceSpecial).'</p>';
		}
		else{
			echo '<p class="b0-price b0-price-general">Цена: ' . render_price($item->priceGeneral) . '</p>';
			echo '<p class="b0-price b0-price-delivery uk-text-danger">Цена при доставке по СПб: ' . render_price($item->priceDelivery) . '</p>';
			echo '<p>Вы экономите ' . render_economy($item->priceGeneral, $item->priceDelivery).'</p>';
		}
	}
	
	/**
	 * @param object $item
	 * @param string $linkDelivery
	 */
	public function renderPriceRelated(object $item, string $linkDelivery = '')
	{
		if ($item->priceGeneral == 0) {
			return;
		}
		if ($item->isByOrder) {
			echo '<p class="b0-price b0-price-related">Ожидается поступление</p>';
			echo '<p class="b0-price b0-price-general uk-text-muted">Цена уточняется при заказе</p>';
		}
		elseif ($item->isSpecial) {
			echo '<p class="b0-price b0-price-related uk-text-danger">Специальная цена: ' . render_price($item->priceSpecial) . '</p>';
			echo '<p class="b0-price b0-price-related">Цена: <del>' . render_price($item->priceGeneral) . '</del>';
		}
		else {
			echo '<p class="b0-price b0-price-related">Цена: ' . render_price($item->priceGeneral). '</p>';
			echo '<p class="b0-price b0-price-related uk-text-danger">Цена при доставке: ' . render_price($item->priceDelivery) . '</p>';
				echo '<p>Вы экономите ' . render_economy($item->priceGeneral, $item->priceDelivery).
					'&nbsp;<small>(Подробнее об <a href="'. $linkDelivery .
					'" target="_blank" title="Условия доставки">условиях Доставки</a>)</small></p>';
		}
	}
	
	public function renderCart(object $item)
	{
		//TODO
	}
}

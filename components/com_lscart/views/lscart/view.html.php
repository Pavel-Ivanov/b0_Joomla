<?php

defined('_JEXEC') or die();

JImport('b0.Cart.Cart');
JImport('b0.Cart.CartItem');
JImport('b0.fixtures');

class LscartViewLscart extends JViewLegacy
{
	public $cart;

	public function display($tpl = null) {
		$cart = JFactory::getApplication()->getUserState('cart');
		if(!$cart) {
			parent::display('empty');
			return;
		}

		//вызываем метод модели getItems() -> _getListQuery() -> getListQuery()
		// getItems получает список элементов через вызов getListQuery(), поэтому в модели надо переопределить getListQuery()

		$goods = $this->get('Items');
		$this->cart = new Cart($goods);
		//$this->cart = new Cart();
		//b0debug($this->cart);
		parent::display($tpl);
	}
}
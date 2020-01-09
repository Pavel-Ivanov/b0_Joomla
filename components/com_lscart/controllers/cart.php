<?php
defined('_JEXEC') or die();

JImport('b0.Cart.Cart');
JImport('b0.Sparepart.SparepartIds');
JImport('b0.Accessory.AccessoryIds');
//JImport('b0.fixtures');

/**
 * Class LscartControllerCart
 */
class LscartControllerCart extends JControllerLegacy
{
	public function add() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$item_id = $input->get('item_id', 1);
		$item_quantity = $input->get('item_quantity', 1);
		$item = unserialize($input->get('item', '', 'string'));
		$item['quantity'] = $item_quantity;
		// получить значение из сесии
		$cart = $app->getUserState('cart');
		// записать значение в сессию
		$cart[$item_id] = $item;
		// сохранить сессию
		$app->setUserState('cart', $cart);
		jexit('success');
	}

	public function delete() {
		$app = JFactory::getApplication();
		$cart = $app->getUserState('cart');
		$item_id = $app->input->get('item_id', 1);
		unset ($cart[$item_id]);
		$app->setUserState('cart', $cart);
		jexit('success');
	}

	public function deleteAll() {
		$app = JFactory::getApplication();
		$app->setUserState('cart', null);
		jexit('success');
	}

	public function save()
	{
		$app = JFactory::getApplication();
		$siteName = JFactory::getConfig()->get('sitename');
		$name = $_POST["name"];
		$phone = $_POST["phone"];
		$email = $_POST["email"];

		$emailParamsSystem = [
			'from' => 'delivery@logan-shop.spb.ru',
			'fromName'  => 'Отдел доставки ' . $siteName,
			'recipient' => ['delivery@logan-shop.spb.ru', 'v.bushkevich@logan-shop.spb.ru', 'serg07888@mail.ru'],
			'subject'   => 'Заказ на запчасти в ' . $siteName,
			'body'      => ''
		];

		$emailParamsUser = [
			'from'      => 'delivery@logan-shop.spb.ru',
			'fromName'  => 'Отдел доставки ' . $siteName,
			'recipient' => $email,
			'subject'   => 'Заказ на запчасти в ' . $siteName,
			'body'      => ''
		];

/*		$smsParamsSystem = [
			'text' => 'Получен заказ ' . $siteName . ' / '. $name . ' / 8-' . $phone,
			'number' => '79111998979'
		];

		$smsParamsUser = [
			'text' => 'Ваш заказ в ' . $siteName . ' принят. Мы перезвоним Вам в течение часа в рабочее время',
			'number' => '7'.str_replace('-', '', $phone)
		];*/
		
		$cart = $app->getUserState('cart');
		if (!$cart) {
			return;
		}
		$cart_keys = implode(',', array_keys($cart));
		// Получаем записи из БД
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$query->select('id, title, type_id, alias, fields');
		$query->from('#__js_res_record');
		$query->where('id IN ('.$cart_keys.')');
		$query->order('title');
		$db->setQuery($query);
		$goods = $db->loadObjectList();
		
		// Формируем массив данных для записи в БД
		foreach ($goods as $item) {
			$fields = json_decode($item->fields, TRUE);
			$cart[$item->id]['title'] = $item->title;
			$cart[$item->id]['code'] = $item->type_id == SparepartIds::ID_TYPE ? $fields[SparepartIds::ID_PRODUCT_CODE] : $fields[AccessoryIds::ID_PRODUCT_CODE];
			$cart[$item->id]['price'] = $item->type_id == SparepartIds::ID_TYPE ? $fields[SparepartIds::ID_PRICE_DELIVERY] : $fields[AccessoryIds::ID_PRICE_DELIVERY];
			$cart[$item->id]['sedova'] = $item->type_id == SparepartIds::ID_TYPE ? $fields[SparepartIds::ID_SEDOVA] : $fields[AccessoryIds::ID_SEDOVA];
			$cart[$item->id]['khimikov'] = $item->type_id == SparepartIds::ID_TYPE ? $fields[SparepartIds::ID_KHIMIKOV] : $fields[AccessoryIds::ID_KHIMIKOV];
			$cart[$item->id]['zhukova'] = $item->type_id == SparepartIds::ID_TYPE ? $fields[SparepartIds::ID_ZHUKOVA] : $fields[AccessoryIds::ID_ZHUKOVA];
			$cart[$item->id]['kultury'] = $item->type_id == SparepartIds::ID_TYPE ? $fields[SparepartIds::ID_KULTURY] : $fields[AccessoryIds::ID_KULTURY];
		}
		// Сохраняем запись в БД
		$data_db = [
			'name' => $name,
			'phone' => $phone,
			'email' => $email,
			'created' => JHtml::date('now', 'Y-m-d H:i:s'),
			'data' => json_encode($cart, JSON_UNESCAPED_UNICODE)
		];
		
		JTable::addIncludePath(JPATH_COMPONENT.'/tables/');
		$row = JTable::getInstance('order', 'Table');
		$row->reset();
		
		if (!$row->check()) {
			exit();
		}
		
		if (!$row->bind($data_db)){
			exit();
		}
		if (!$row->store()){
			exit();
		}
		
		$db->setQuery("SELECT MAX(id) FROM #__lscart_orders");
		$lastId = $db->loadResult();
		$orderNumber = 'Логан-' .date('Y-m-d') . '-' . $lastId;
		
		$smsParamsSystem = [
			'text' => 'Заказ ' . $orderNumber . ' / '. $name . ' / 8-' . $phone,
			'number' => '79111998979'
		];
		
		$smsParamsUser = [
			'text' => 'Ваш заказ ' . $orderNumber . ' принят, ожидайте звонка',
			'number' => '7'.str_replace('-', '', $phone)
		];
		
		// Формируем текст письма
		$emailBody = '';
		$emailBodyCustomer = '';
		if ($lastId) {
			$emailBody .= 'Номер заказа: '. $orderNumber . '<br>';
			$emailBodyCustomer .= 'Номер Заказа: '. $orderNumber . '<br>';
		}
		if ($name) {
			$emailBody .= 'Контактное лицо: '. $name . '<br>';
			$emailBodyCustomer .= 'Контактное лицо: '. $name . '<br>';
		}
		$emailBody .= 'Контактный телефон: +7-'. $phone . '<br>';
		$emailBodyCustomer .= 'Контактный телефон: +7-'. $phone . '<br>';
		if ($email) {
			$emailBody .= 'Email: '. $email . '<br>';
			$emailBodyCustomer .= 'Email: '. $email . '<br>';
		}
		$emailBody .= '<br><strong>Заказанные товары: </strong><br>';
		$emailBodyCustomer .= '<br><strong>Заказанные товары: </strong><br>';

		$totalPrice = 0;
		foreach ($goods as $item) {
			$cartItem = $cart[$item->id];
			$totalPrice += $cart[$item->id]['quantity'] * $cart[$item->id]['price'];

			$emailBody .= $cart[$item->id]['code'] . ' / ' . $item->title . ' - <b>' .
				$cart[$item->id]['quantity'] . '</b> шт. * '.$cart[$item->id]['price'].
				' руб. = '.$cart[$item->id]['quantity'] * $cart[$item->id]['price'].' руб.<br>';
			$emailBodyCustomer .= $cart[$item->id]['code'] . ' / ' . $item->title . ' - <b>' .
				$cart[$item->id]['quantity'] . '</b> шт. * '.$cart[$item->id]['price'].
				' руб. = '.$cart[$item->id]['quantity'] * $cart[$item->id]['price'].' руб.<br>';
			$emailBody .= '     *** наличие: седова- <b>'.$cart[$item->id]['sedova'].'</b> / химиков- <b>'.$cart[$item->id]['khimikov'].
				'</b> / жукова- <b>'.$cart[$item->id]['zhukova'].'</b> / культуры- <b>'.$cart[$item->id]['kultury'].'</b><br>';
			$emailBody .= '<br>';
		}
		$emailBody .= 'Общая  сумма: ' . $totalPrice . ' руб.';
		$emailBodyCustomer .= 'Общая  сумма: ' . $totalPrice . ' руб.';

		$emailParamsSystem['body'] = $emailBody;
		$this->sendMail($emailParamsSystem);

		if (isset($email)) {
			$emailParamsUser['body'] = $emailBodyCustomer;
			$this->sendMail($emailParamsUser);
		}

		$this->sendSMS($smsParamsSystem);

		$this->sendSMS($smsParamsUser);

		//TODO сделать проверку на отправку Email
		$app->setUserState('cart', '');
		jexit('success');
	}

	public function changeQuantity() {
		$app = JFactory::getApplication();
		$input = $app->input;
		$item_id = $input->get('item_id', 1);
		$item_quantity = $input->get('item_quantity', 1);
		$cart = $app->getUserState('cart');
		$cart[$item_id] = ['quantity' => $item_quantity];
		$app->setUserState('cart', $cart);
		jexit('success');
	}

	private function sendMail($params) {

		$result = JFactory::getMailer()->sendMail($params['from'], $params['fromName'], $params['recipient'], $params['subject'], $params['body'], TRUE);
		return $result;
	}

	private function sendSMS($params) {
		$query = "http://gate.sms-manager.ru/_getsmsd.php?user=logan&password=753636&sender=LoganShop&SMSText=".$params['text']."&GSM=".$params['number'];
		$result = file_get_contents($query);
		return $result;
	}
}

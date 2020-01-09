<?php
/**
 * @package Cobal controller for synchronization with 1C
 * @version 1.1.1
 * @author Pavel Ivanov
 **/
defined('_JEXEC') or die();

JImport('b0.Sparepart.SparepartIds');
JImport('b0.Sparepart.SparepartKeys');
JImport('b0.Accessory.AccessoryIds');
JImport('b0.Accessory.AccessoryKeys');
JImport('b0.Work.WorkIds');
JImport('b0.Work.WorkKeys');
JImport('b0.Yml.Yml');
JImport('b0.fixtures');
require_once JPATH_ROOT . '/components/com_cobalt/api.php';

class CobaltControllerB0Sync extends JControllerLegacy
{
	private $log_file_path = "/logs/b0_sync_1c.txt";
	private $log_file_handle;
	private $logs = [];
	/** @var bool $needYml
	 * признак необходимости формирования YML файла
	 */
	private $needYml = false;

	// Разрешать синхронизацию из карточки товара
	private $enableSyncSave = true;
	// Разрешать синхронизацию из расходных документов
	private $enableSyncSaveRemains = true;
	// Разрешать установку контроля версий
	private $enableVersionControl = false;
	// Разрешать формирование YML файла
	private $enableYml = true;
	// Разрешать отправку Email при успешном результате
	private $enableSuccessEmail = false;
	// Разрешать запись лога при успешном результате
	private $enableSuccessLogs = false;
	// Разрешать запись входного массива
	private $enableRequestLog = true;

	// Ключ поля Код товара - Запчасть
	private $productCodeSparepart = SparepartKeys::KEY_PRODUCT_CODE;
	// Ключ поля Код товара - Аксессуар
	private $productCodeAccessory = AccessoryKeys::KEY_PRODUCT_CODE;
	// Ключ поля Код услуги
	private $serviceCode = WorkKeys::KEY_SERVICE_CODE;
	// Коэффициент цены при первом визите
	private $discountFirstVisit = 0.8;
	// Параметры отправки почты
	private $emailFrom = 'admin@logan-shop.spb.ru';
	private $emailFromName  = 'Admin';
	private $emailRecipient = ['p.ivanov@logan-shop.spb.ru'];
	private $emailSubject = 'Синхронизация Logan-Shop';
	
	// Вызов /index.php?option=com_cobalt&task=b0sync.save
	
	/**
	 * Синхронизация из карточки товара
	 *
	 * @since version
	 * @throws Exception
	 */
	public function save()
	{
		$this->setParams();
		// Если синхронизация запрещена- выход
		if (!$this->enableSyncSave) {
			jexit('Синхронизация запрещена');
		}
		$this->logs[] = 'Карточка товара/услуги';
		// Получаем входной запрос
		$request = $this->getRequest();
		$requestId = $_GET['id'];
		$requestTotal = $_GET['total'] ?? 0;
		if (empty($request)) {
			$this->logs[] = 'Пустое тело входного запроса, код товара: ' . $requestId;
			$this->emailSubject .= " - Пустое тело входного запроса";
			$this->writeLogs();
			$this->sendMail();
			jexit('Пустое тело входного запроса');
		}
		
		if ($this->enableRequestLog) {
			$this->logs[] = 'Входной массив:';
			$this->logs[] = print_r($request, true);
			$this->logs[] = 'total: ' . print_r($requestTotal, true);
		}

		// Проверяем входной запрос на валидность id
		if (!$this->verifyId($request)) {
			$this->logs[] = 'Входной запрос не прошел валидацию на id: ' . $requestId;
			$this->emailSubject .= " - Входной запрос не прошел валидацию на id";
			$this->writeLogs();
			$this->sendMail();
			jexit('Входной запрос не прошел валидацию на id');
		}
		// Получаем id записи по коду товара/услуги
		$recordId = $this->getRecordId($request['id']);
		if ($recordId == 0) {
			$this->logs[] = 'Запись с кодом товара/услуги ' . $request['id'] . ' не найдена';
			$this->emailSubject .= " - Запись с кодом товара/услуги не найдена";
			$this->writeLogs();
			$this->sendMail();
			jexit('Запись с кодом товара/услуги ' . $request['id'] . ' не найдена');
		};
		// Получаем запись по id
		$record = $this->getRecord($recordId);

		//TODO сделать проверку на наличие записи

		// Получаем id типа записи
		$typeId = $record->type_id;

		// Проверяем входной запрос
		if (!$this->verifyRequest($request, $typeId)) {
			$this->logs[] = 'Входной запрос не прошел верификацию';
			$this->emailSubject .= " - Входной запрос не прошел верификацию";
			$this->writeLogs();
			$this->sendMail();
			jexit('Входной запрос не прошел верификацию');
		};

		// Получаем поля записи
		$fields = json_decode($record->fields, true);

		// Устанавливаем новые значения полей
		$newFields = $this->setFields($fields, $typeId, $request);

		// Обновляем запись
		if (!CobaltApi::updateRecord($recordId, [], $newFields)) {
			$this->logs[] = "Ошибка обновления записи";
			$this->emailSubject .= " - Ошибка обновления записи";
			$this->writeLogs();
			$this->sendMail();
			jexit('Ошибка обновления записи');
		};
		$this->logs[] = "Успешное обновление записи: ".$recordId;
		$this->emailSubject .= " - Успешное обновление записи";

		// Запись контроля версий
		if ($this->enableVersionControl) {
			// Получаем объект типа записи
			$type = $this->getType($typeId);
			$versions = JTable::getInstance('Audit_versions', 'CobaltTable');
			$version  = $versions->snapshot($recordId, $type);
			$record->version = $version;
			$this->logs[] = 'Успешная запись контроля версий, версия: ' . print_r($version, true);
		}

		// Формирование YML файла
		if ($this->enableYml){
			if (($typeId == SparepartIds::ID_TYPE OR $typeId == AccessoryIds::ID_TYPE) AND $requestTotal == 0){
				$yml = new Yml();
/*				if ($yml->render()){
					$this->logs[] = "Успешное формирование YML файла";
				}
				else {
					$this->logs[] = "Ошибка формирования YML файла";
					$this->writeLogs();
					$this->sendMail();
					jexit('Ошибка формирования YML файла: '.$recordId);
				}*/
				$resYMarket = $yml->renderYMarketFile();
				if ($resYMarket) {
					$this->logs[] = "Успешное формирование YMarket файла";
				}
				else {
					$this->logs[] = "Ошибка формирования YMarket файла";
					$this->writeLogs();
					$this->sendMail();
					jexit('Ошибка формирования YMarket файла');
				}
				
				$resYFull = $yml->renderYFullFile();
				if ($resYFull) {
					$this->logs[] = "Успешное формирование YFull файла";
				}
				else {
					$this->logs[] = "Ошибка формирования YFull файла";
					$this->writeLogs();
					$this->sendMail();
					jexit('Ошибка формирования YFull файла');
				}

			}
		}

		// Запись логов
		if ($this->enableSuccessLogs) {
			$this->writeLogs();
		}

		// Отправка почты
		if ($this->enableSuccessEmail) {
			$this->sendMail();
		}
		jexit("Успешное обновление записи: ".$recordId);
	}
	
	/**
	 * Синхронизация из расходного / приходного документа
	 * Вызов /index.php?option=com_cobalt&task=b0sync.save_remains
	 * @since version
	 * @throws Exception
	 */
	public function save_remains () {
		$this->setParams();
		// Если синхронизация запрещена- выход
		if (!$this->enableSyncSaveRemains) {
			jexit('Синхронизация запрещена');
		}
		$this->logs[] = 'Расходный документ';
		$request = $this->getRequest();
		if (empty($request)) {
			$this->logs[] = 'Пустое тело входного запроса';
			$this->emailSubject .= " - Пустое тело входного запроса";
			$this->writeLogs();
			$this->sendMail();
			jexit('Пустое тело входного запроса');
		}
		
		if ($this->enableRequestLog) {
			$this->logs[] = 'Входной массив:';
			$this->logs[] = print_r($request, true);
		}

		foreach ($request as $id => $post) {
			// Получаем id записи по коду товара/услуги
			$recordId = $this->getRecordId($id);
			if ($recordId == 0) {
				$this->logs[] = 'Запись с кодом товара/услуги ' . $id . ' не найдена';
				$this->emailSubject .= " - Запись с кодом товара/услуги не найдена";
				$this->writeLogs();
				$this->sendMail();
				jexit('Запись с кодом товара/услуги ' . $id . ' не найдена');
			};
			// Получаем запись по id
			$record = $this->getRecord($recordId);
			// Получаем id типа записи
			$typeId = $record->type_id;

			// Проверяем входной запрос
			if (!$this->verifyRequestRemains($post)){
				//$this->writeLog('Входной запрос не прошел верификацию');
				$this->logs[] = 'Входной запрос не прошел верификацию';
				$this->emailSubject .= " - Входной запрос не прошел верификацию";
				$this->writeLogs();
				$this->sendMail();
				jexit('Входной запрос не прошел верификацию');
			};
			// Получаем поля записи
			$fields = json_decode($record->fields, true);

			// Устанавливаем новые значения полей
			$newFields = $this->setFieldsRemains($fields, $typeId, $post);

			// Обновляем запись
			if (!CobaltApi::updateRecord($recordId, [], $newFields)) {
				$this->logs[] = "Ошибка обновления записи";
				$this->emailSubject .= " - Ошибка обновления записи";
				$this->writeLogs();
				$this->sendMail();
				jexit('Ошибка обновления записи');
			};
			$this->logs[] = 'Успешное обновление записи ' . $id .
				' / sedova- ' . $post['re_sedova'].
				', khimikov- ' . $post['re_khimikov'].
				', zhukova- ' . $post['re_zhukova'].
				', kultury- ' . $post['re_kultury'];
			$this->setNeedYml($fields, $newFields, $typeId);
		}
		$this->emailSubject .= " - Успешное обновление записи";
		// Создание YML файла
		if ($this->enableYml){
			if ($this->needYml) {
				$yml = new Yml();
				$resYMarket = $yml->renderYMarketFile();
				if ($resYMarket) {
					$this->logs[] = "Успешное формирование YMarket файла";
				}
				else {
					$this->logs[] = "Ошибка формирования YMarket файла";
					$this->writeLogs();
					$this->sendMail();
					jexit('Ошибка формирования YMarket файла');
				}
				
				$resYFull = $yml->renderYFullFile();
				if ($resYFull) {
					$this->logs[] = "Успешное формирование YFull файла";
				}
				else {
					$this->logs[] = "Ошибка формирования YFull файла";
					$this->writeLogs();
					$this->sendMail();
					jexit('Ошибка формирования YFull файла');
				}
			}
		}
		
		// Запись логов
		if ($this->enableSuccessLogs) {
			$this->writeLogs();
		}

		// Отправка почты
		if ($this->enableSuccessEmail) {
			$this->sendMail();
		}
		JExit("Успешное обновление");
	}
	
	/**
	 * Устанавливает параметры на основании параметров Cobalt
	 *
	 * @throws Exception
	 * @since version
	 */
	private function setParams()
	{
		/** @var JRegistry $paramsApp */
		$paramsApp = JFactory::getApplication()->getParams();
		$this->enableSyncSave = $paramsApp->get('enableSyncSave', true);
		$this->enableSyncSaveRemains = (bool)$paramsApp->get('enableSyncSaveRemains', true);
		$this->enableVersionControl = $paramsApp->get('enableVersionControl', false);
		$this->enableYml = $paramsApp->get('enableYml', true);
		$this->enableSuccessEmail = $paramsApp->get('enableSuccessEmail', false);
		$this->enableSuccessLogs = $paramsApp->get('enableSuccessLogs', false);
		$this->enableRequestLog = $paramsApp->get('enableRequestLog', false);
	}

	/**
	 * Возвращает тело входного запроса
	 *
	 * @return array
	 *
	 * @since version
	 */
	private function getRequest():array
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	/**
	 * Проверяет входной запрос на наличие и правильность кода товара/услуги
	 *
	 * @param array $request - входной запрос
	 *
	 * @return bool
	 *
	 * @since version
	 */
	private function verifyId(array $request): bool
	{
		if (!isset($request['id'])) {
			$this->logs[] = 'Отсутствует код товара/услуги';
			return false;
		}
		if (!preg_match("/^[0-9]{1,5}$/", $request['id'])) {
			$this->logs[] = "Id не число";
			return false;
		}
		return true;
	}

	/**
	 * @param string $code1c - код товара / услуги в 1С
	 *
	 * @return int - результат выполнения:
	 *             id записи - запись найдена
	 *             0 - запись не найдена
	 *
	 * @since version
	 */
	private function getRecordId(string $code1c): int
	{
		$db = JFactory::getDbo();
		$query = "SELECT record_id FROM #__js_res_record_values
			WHERE ((field_key='{$this->productCodeSparepart}' OR field_key='{$this->productCodeAccessory}' OR field_key='{$this->serviceCode}') AND field_value='{$code1c}')";
		$db->setQuery($query);
		$id = $db->loadResult();
		if ($id) {
			return $id;
		}
		else {
			return 0;
		}
	}

	/**
	 * Проверяет входной запрос на наличие всех параметров для карточки товара
	 *
	 * @param array $request - входной запрос
	 * @param string $typeId - id типа записи
	 *
	 * @return bool
	 *
	 * @since version
	 */
	private function verifyRequest(array $request, string $typeId): bool
	{
		if (!isset($request['price_general'])) {
			$this->logs[] = "price_general отсутствует<br>";
			return false;
		}
		if (!isset($request['price_simple'])) {
			$this->logs[] = "price_simple отсутствует<br>";
			return false;
		}
		if (!isset($request['price_silver'])) {
			$this->logs[] = "price_silver отсутствует<br>";
			return false;
		}
		if (!isset($request['price_gold'])) {
			$this->logs[] = "price_gold отсутствует<br>";
			return false;
		}
		if (!isset($request['is_special'])) {
			$this->logs[] = "is_special отсутствует<br>";
			return false;
		}
		if (!isset($request['price_special'])) {
			$this->logs[] = "price_special отсутствует<br>";
			return false;
		}
		if ($typeId == SparepartIds::ID_TYPE OR $typeId == AccessoryIds::ID_TYPE) {
			if (!isset($request['price_delivery'])) {
				$this->logs[] = "price_delivery отсутствует<br>";
				return false;
			}
			if (!isset($request['is_original'])) {
				$this->logs[] = "is_original отсутствует<br>";
				return false;
			}
			if (!isset($request['is_by_order'])) {
				$this->logs[] = "is_by_order отсутствует<br>";
				return false;
			}
			if (!isset($request['re_sedova'])) {
				$this->logs[] = "re_sedova отсутствует<br>";
				return false;
			}
			if (!isset($request['re_khimikov'])) {
				$this->logs[] = "re_khimikov отсутствует<br>";
				return false;
			}
			if (!isset($request['re_zhukova'])) {
				$this->logs[] = "re_zhukova отсутствует<br>";
				return false;
			}
			if (!isset($request['re_kultury'])) {
				$this->logs[] = "re_kultury отсутствует<br>";
				return false;
			}
		}
		return true;
	}

	/**
	 * Проверяет входной запрос на наличие всех параметров для расходного документа
	 *
	 * @param array $request - входной запрос
	 *
	 * @return bool
	 *
	 * @since version
	 */
	private function verifyRequestRemains(array $request): bool
	{
		if (!isset($request['re_sedova'])) {
			$this->logs[] = "re_sedova отсутствует<br>";
			return false;
		}
		if (!isset($request['re_khimikov'])) {
			$this->logs[] = "re_khimikov отсутствует<br>";
			return false;
		}
		if (!isset($request['re_zhukova'])) {
			$this->logs[] = "re_zhukova отсутствует<br>";
			return false;
		}
		if (!isset($request['re_kultury'])) {
			$this->logs[] = "re_kultury отсутствует<br>";
			return false;
		}
		return true;
	}

	/**
	 * Возвращает объект записи по id
	 *
	 * @param string $recordId - id записи
	 *
	 * @return stdClass - объект записи
	 *
	 * @since version
	 */
	private function getRecord(string $recordId): stdClass
	{
		return ItemsStore::getRecord($recordId);
	}

	/**
	 * Возвращает объект типа записи по id типа
	 *
	 * @param $typeId - id типа записи
	 *
	 * @return stdClass - объект типа записи
	 *
	 * @since version
	 */
	private function getType(string $typeId): stdClass
	{
		return ItemsStore::getType($typeId);
	}
	
	/**
	 * Устанавливает новые поля записи для карточки товара
	 *
	 * @param array $fields  - массив полей записи
	 * @param string $typeId  - id типа записи
	 * @param array $request - входной запрос
	 *
	 * @return array
	 *
	 * @since version
	 * @throws Exception
	 */
	private function setFields(array $fields, string $typeId, array $request): array
	{
//		$newFields = $fields;
		$newFields = [];
		if ($typeId == SparepartIds::ID_TYPE) { // Запчасть
			// Устанавливаем поля цен
			$newFields[SparepartIds::ID_PRICE_GENERAL] = $request['price_general'] ?? "0";
			$newFields[SparepartIds::ID_PRICE_SPECIAL] = $request['price_special'] ?? "0";
			$newFields[SparepartIds::ID_PRICE_SIMPLE] = $request['price_simple'] ?? "0";
			$newFields[SparepartIds::ID_PRICE_SILVER] = $request['price_silver'] ?? "0";
			$newFields[SparepartIds::ID_PRICE_GOLD] = $request['price_gold'] ?? "0";
			$newFields[SparepartIds::ID_PRICE_DELIVERY] = $request['price_delivery'] ?? "0";
			$newFields[SparepartIds::ID_IS_ORIGINAL] = $request['is_original'] ?? "-1";
			$newFields[SparepartIds::ID_IS_SPECIAL] = $request['is_special'] ?? "-1";
			$ibo = $request['is_by_order'] ?? "-1";
			$ibw = $request['is_wait'] ?? "-1";
			if ($ibo ==1 || $ibw == 1) {
				$newFields[SparepartIds::ID_IS_BY_ORDER] = 1;
			}
			else {
				$newFields[SparepartIds::ID_IS_BY_ORDER] = -1;
			}
			// Устанавливаем поля наличия
			$newFields[SparepartIds::ID_SEDOVA] = $request['re_sedova'] ?? "0";
			$newFields[SparepartIds::ID_KHIMIKOV] = $request['re_khimikov'] ?? "0";
			$newFields[SparepartIds::ID_ZHUKOVA] = $request['re_zhukova'] ?? "0";
			$newFields[SparepartIds::ID_KULTURY] = $request['re_kultury'] ?? "0";
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {   // Аксессуар
			// Устанавливаем поля цен
			$newFields[AccessoryIds::ID_PRICE_GENERAL] = $request['price_general'] ?? "0";
			$newFields[AccessoryIds::ID_PRICE_SPECIAL] = $request['price_special'] ?? "0";
			$newFields[AccessoryIds::ID_PRICE_SIMPLE] = $request['price_simple'] ?? "0";
			$newFields[AccessoryIds::ID_PRICE_SILVER] = $request['price_silver'] ?? "0";
			$newFields[AccessoryIds::ID_PRICE_GOLD] = $request['price_gold'] ?? "0";
			$newFields[AccessoryIds::ID_PRICE_DELIVERY] = $request['price_delivery'] ?? "0";
			$newFields[AccessoryIds::ID_IS_ORIGINAL] = $request['is_original'] ?? "-1";
			$newFields[AccessoryIds::ID_IS_SPECIAL] = $request['is_special'] ?? "-1";
			$ibo = $request['is_by_order'] ?? "-1";
			$ibw = $request['is_wait'] ?? "-1";
			if ($ibo ==1 || $ibw == 1) {
				$newFields[AccessoryIds::ID_IS_BY_ORDER] = 1;
			}
			else {
				$newFields[AccessoryIds::ID_IS_BY_ORDER] = -1;
			}
			// Устанавливаем поля наличия
			$newFields[AccessoryIds::ID_SEDOVA] = $request['re_sedova'] ?? "0";
			$newFields[AccessoryIds::ID_KHIMIKOV] = $request['re_khimikov'] ?? "0";
			$newFields[AccessoryIds::ID_ZHUKOVA] = $request['re_zhukova'] ?? "0";
			$newFields[AccessoryIds::ID_KULTURY] = $request['re_kultury'] ?? "0";
		}
		elseif ($typeId == WorkIds::ID_TYPE) {   // Работа
			// Устанавливаем поля цен
			$newFields[WorkIds::ID_PRICE_GENERAL] = $request['price_general'] ?? "0";
			$newFields[WorkIds::ID_PRICE_SIMPLE] = $request['price_simple'] ?? "0";
			$newFields[WorkIds::ID_PRICE_SILVER] = $request['price_silver'] ?? "0";
			$newFields[WorkIds::ID_PRICE_GOLD] = $request['price_gold'] ?? "0";
			$newFields[WorkIds::ID_PRICE_FIRST_VISIT] = isset($request['price_general']) ? $request['price_general'] * $this->discountFirstVisit : "0";
			$newFields[WorkIds::ID_IS_SPECIAL] = $request['is_special'] ?? "-1";
			$newFields[WorkIds::ID_PRICE_SPECIAL] = $request['price_special'] ?? "0";
		}
		else {
			$this->logs[] ='не тот раздел- ' . $typeId . "\n";
			$this->writeLogs();
			$this->sendMail();
			jexit('не тот раздел- ' . $typeId);
		}
		return $newFields;
	}
	
	/**
	 * Устанавливает новые поля записи для расходного документа
	 *
	 * @param array  $fields
	 * @param string $typeId
	 * @param array  $post
	 *
	 * @return array
	 *
	 * @since version
	 * @throws Exception
	 */
	private function setFieldsRemains(array $fields, string $typeId, array $post):array
	{
//		$newFields = $fields;
		$newFields = [];
		if ($typeId == SparepartIds::ID_TYPE) { // Запчасть
			$newFields[SparepartIds::ID_SEDOVA] = $post['re_sedova'] ?? "0";
			$newFields[SparepartIds::ID_KHIMIKOV] = $post['re_khimikov'] ?? "0";
			$newFields[SparepartIds::ID_ZHUKOVA] = $post['re_zhukova'] ?? "0";
			$newFields[SparepartIds::ID_KULTURY] = $post['re_kultury'] ?? "0";
			// устанавливаем поле Под Заказ
			if ($post['re_sedova']==0 AND $post['re_khimikov']==0 AND $post['re_zhukova']==0 AND $post['re_kultury']==0) {
				//TODO
				$newFields[SparepartIds::ID_IS_BY_ORDER] = 1;
			}
			else {
				$newFields[SparepartIds::ID_IS_BY_ORDER] = -1;
			}
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {   // Аксессуар
			$newFields[AccessoryIds::ID_SEDOVA] = $post['re_sedova'] ?? "0";
			$newFields[AccessoryIds::ID_KHIMIKOV] = $post['re_khimikov'] ?? "0";
			$newFields[AccessoryIds::ID_ZHUKOVA] = $post['re_zhukova'] ?? "0";
			$newFields[AccessoryIds::ID_KULTURY] = $post['re_kultury'] ?? "0";
			// устанавливаем поле Под Заказ
			if ($post['re_sedova']==0 AND $post['re_khimikov']==0 AND $post['re_zhukova']==0 AND $post['re_kultury']==0) {
				//TODO
				$newFields[AccessoryIds::ID_IS_BY_ORDER] = 1;
			}
			else {
				$newFields[AccessoryIds::ID_IS_BY_ORDER] = -1;
			}
		}
		else {
			$this->logs[] ='не тот раздел' . $typeId;
			$this->writeLogs();
			$this->sendMail();
			jexit('не тот раздел' . $typeId);
		}
		return $newFields;
	}
	
	/**
	 * Устанавливает необходимость формирования Yml файла
	 *
	 * @param array  $fields
	 * @param array  $newFields
	 * @param string $typeId
	 *
	 * @return bool | null
	 *
	 * @since version
	 * @throws Exception
	 */
	private function setNeedYml(array $fields, array $newFields, string $typeId)
	{
		if ($typeId == SparepartIds::ID_TYPE) { // Запчасть
			if ($fields[SparepartIds::ID_IS_BY_ORDER] !== $newFields[SparepartIds::ID_IS_BY_ORDER])
			{
				$this->logs[]  = 'Под заказ запчасть: ' . $fields[SparepartIds::ID_IS_BY_ORDER] . '/' . $newFields[SparepartIds::ID_IS_BY_ORDER];
				$this->needYml = true;
			}
		}
		elseif ($typeId == AccessoryIds::ID_TYPE) {   // Аксессуар
			if ($fields[AccessoryIds::ID_IS_BY_ORDER] !== $newFields[AccessoryIds::ID_IS_BY_ORDER])
			{
				$this->logs[]  = 'Под заказ аксессуар: ' . $fields[AccessoryIds::ID_IS_BY_ORDER] . '/' . $newFields[AccessoryIds::ID_IS_BY_ORDER];
				$this->needYml = true;
			}
		}
		else {
			$this->logs[] ="не тот раздел- " . $typeId;
			$this->writeLogs();
			$this->sendMail();
			jexit('не тот раздел' . $typeId);
		}
	}
	
	/**
	 * Записывает log файл
	 * @since version
	 * @throws Exception
	 */
	private function writeLogs()
	{
		$this->log_file_handle = fopen(JPATH_ROOT . $this->log_file_path, "a+");
		if ($this->log_file_handle == false) {
			fclose($this->log_file_handle);
			die('Ошибка открытия файла лога');
		}

		fwrite($this->log_file_handle, '===== ' . date_format(new DateTime(), 'Y-m-d H:i:s') . ' =====' . "\n");

		foreach ($this->logs as $log) {
			fwrite($this->log_file_handle, $log . "\n");
		}
		fclose($this->log_file_handle);
	}
	
	/**
	 * Отправляет почту
	 * @return bool
	 *
	 * @since version
	 */
	private function sendMail()
	{
		$messageBody = '';
		foreach ($this->logs as $log) {
			$messageBody .= $log . "\n";
		}
		$result = JFactory::getMailer()->sendMail($this->emailFrom, $this->emailFromName, $this->emailRecipient, $this->emailSubject, $messageBody, TRUE);
		return $result;
	}
}

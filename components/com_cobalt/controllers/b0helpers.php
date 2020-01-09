<?php
defined('_JEXEC') or die;

JImport('b0.Work.WorkIds');
JImport('b0.Sparepart.SparepartIds');
JImport('b0.fixtures');

class CobaltControllerB0Helpers extends JControllerForm
{
    //* Функция устанавливает точное значение поля Под Заказ [96]
    // https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0helpers.setbyorder
    public function setByOrder()
    {
        echo '<h3>Устанавливаем значение поля Под Заказ</h3>';
        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);
        $query->select('id, fields, title, alias');
        $query->from('#__js_res_record');
        $query->where('section_id = 2');
        $query->where('published = 1');
        $db->setQuery($query);
        $list = $db->loadObjectList();
        if (!$list) {
            echo 'ошибка запроса к базе данных';
            return;
        }

        foreach ($list as $item) {
            $fields = json_decode($item->fields, TRUE);

            $url = '/spareparts/item/' . $item->id . '-' . $item->alias;
            echo '<p><a href="' . $url . '" target="_blank">' . $item->title . '</a>';

            if (!isset($fields[96]) OR (($fields[96]) == 0)) {
                echo ' / было ' . $fields[96];
                $fields['96'] = (int)-1;
            }

            echo ' / стало ' . $fields[96] . '</p>';

            $fields_string = addslashes(json_encode($fields, JSON_UNESCAPED_UNICODE));
            $db->setQuery("UPDATE #__js_res_record SET fields = '{$fields_string}' WHERE id = " . $item->id);
            $db->execute();
        }
    }

    //* Функция удаляет значение поля Скидка по карте [57]
    // https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0helpers.deletefield57
    public function deleteField57()
    {
        echo '<h3>Удаляем значение поля 57- скидка по карте</h3>';
        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);
        $query->select('id, fields, title, alias');
        $query->from('#__js_res_record');
        $query->where('section_id = 2');
        $query->where('published = 1');
        $db->setQuery($query);
        $list = $db->loadObjectList();
        if (!$list) {
            echo 'ошибка запроса к базе данных';
            return;
        }

        foreach ($list as $item) {
            $fields = json_decode($item->fields, TRUE);

            $url = '/spareparts/item/' . $item->id . '-' . $item->alias;
            echo '<p><a href="' . $url . '" target="_blank">' . $item->title . '</a>';

            if (isset($fields['57'])) {
                unset($fields['57']);
                echo ' / удалили';
            }
            echo '</p>';
            $fields_string = addslashes(json_encode($fields, JSON_UNESCAPED_UNICODE));
            $db->setQuery("UPDATE #__js_res_record SET fields = '{$fields_string}' WHERE id = " . $item->id);
            $db->execute();
        }
    }

    //* Функция устанавливает расчетные цены Запчасть
    // https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0helpers.setpricesspareparts
    public function setPricesSpareparts()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);
        $query->select('id, fields, title, alias');
        $query->from('#__js_res_record');
        $query->where('section_id = 2');
        $query->where('published = 1');
        $db->setQuery($query);
        $list = $db->loadObjectList();
        if (!$list) {
            echo 'ошибка запроса к базе данных';
            return;
        }

        foreach ($list as $item) {
            $fields = json_decode($item->fields, TRUE);

            $url = '/spareparts/item/' . $item->id . '-' . $item->alias;
            echo '<p><a href="' . $url . '" target="_blank">' . $item->title . '</a>';

            $isOriginal = $fields['98'] == 1 ? true : false;
            $isSpecial = $fields['135'] == 1 ? true : false;
            $priceGeneral = $fields['30'];
            //var_dump($isSpecial);
            if ($isSpecial) {
                $fields['103'] = $priceGeneral;
                $fields['104'] = $priceGeneral;
                $fields['105'] = $priceGeneral;
                $fields['106'] = $priceGeneral;
                continue;
            }

            if ($isOriginal) {
                $fields['103'] = round($priceGeneral * 0.99, 0);
                $fields['104'] = round($priceGeneral * 0.98, 0);
                $fields['105'] = round($priceGeneral * 0.97, 0);
                $fields['106'] = round($priceGeneral * 0.95, 0);
            } else {
                $fields['103'] = round($priceGeneral * 0.97, 0);
                $fields['104'] = round($priceGeneral * 0.95, 0);
                $fields['105'] = round($priceGeneral * 0.93, 0);
                $fields['106'] = round($priceGeneral * 0.90, 0);
            }

            $fields_string = addslashes(json_encode($fields, JSON_UNESCAPED_UNICODE));

            $db->setQuery("UPDATE #__js_res_record SET fields = '{$fields_string}' WHERE id = " . $item->id);
            $db->execute();
        }
    }

    //* Функция устанавливает расчетные цены Работа
    // https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0helpers.setpricesworks
    public function setPricesWorks()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);
        $query->select('id, fields, title, alias');
        $query->from('#__js_res_record');
        $query->where('section_id = 1');
        $query->where('published = 1');
        $db->setQuery($query);
        $list = $db->loadObjectList();
        if (!$list) {
            echo 'ошибка запроса к базе данных';
            return;
        }

        foreach ($list as $item) {
            $fields = json_decode($item->fields, TRUE);

            $url = '/spareparts/item/' . $item->id . '-' . $item->alias;
            echo '<p><a href="' . $url . '" target="_blank">' . $item->title . '</a>';

            $isSpecial = $fields[WorkIds::ID_IS_SPECIAL] == 1 ? true : false;
            $priceGeneral = $fields[WorkIds::ID_PRICE_GENERAL];
            $priceSpecial = $fields[WorkIds::ID_PRICE_SPECIAL] ?? 0;
            //var_dump($isSpecial);
            if ($isSpecial) {
                $fields[WorkIds::ID_PRICE_SIMPLE] = $priceSpecial;
                $fields[WorkIds::ID_PRICE_SILVER] = $priceSpecial;
                $fields[WorkIds::ID_PRICE_GOLD] = $priceSpecial;
                $fields[WorkIds::ID_PRICE_FIRST_VISIT] = $priceSpecial;
            } else {
                $fields[WorkIds::ID_PRICE_SIMPLE] = round($priceGeneral * 0.97, 0);
                $fields[WorkIds::ID_PRICE_SILVER] = round($priceGeneral * 0.95, 0);
                $fields[WorkIds::ID_PRICE_GOLD] = round($priceGeneral * 0.93, 0);
                $fields[WorkIds::ID_PRICE_FIRST_VISIT] = round($priceGeneral * 0.80, 0);
                $fields[WorkIds::ID_PRICE_SPECIAL] = 0;
            }
            $fields_string = addslashes(json_encode($fields, JSON_UNESCAPED_UNICODE));

            $db->setQuery("UPDATE #__js_res_record SET fields = '{$fields_string}' WHERE id = " . $item->id);
            $db->execute();

	        $url = '/repair/item/'.$item->id.'-'.$item->alias;
	        echo '<p><a href="'.$url.'" target="_blank">'.$item->title.'</a> / '.'</p>';
        }
    }

	//* Функция устанавливает значение поля Спецпредложение [104]
	// https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0helpers.setisspecial
	public function setIsSpecial()
	{
		echo '<h3>Устанавливаем значение поля Спецпредложение</h3>';
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$query->select('id, fields, title, alias, featured');
		$query->from('#__js_res_record');
		$query->where('section_id = 2');
		$query->where('published = 1');
		$db->setQuery($query);
		$list = $db->loadObjectList();
		if (!$list) {
			echo 'ошибка запроса к базе данных';
			return;
		}

		foreach ($list as $item) {
			$fields = json_decode($item->fields, TRUE);
			if ($item->featured == 1) {
				$fields['135'] = 1;
			}
			else {
				$fields['135'] = -1;
			}
			$fields_string = addslashes(json_encode($fields, JSON_UNESCAPED_UNICODE));

			$url = '/spareparts/item/' . $item->id . '-' . $item->alias;
			echo '<p><a href="' . $url . '" target="_blank">' . $item->title . '</a>';
			echo ' / установлено</p>';

			$db->setQuery("UPDATE #__js_res_record SET fields='{$fields_string}', featured=0 WHERE id = " . $item->id);
			$db->execute();
		}
	}

	// Вызов - /index.php?option=com_cobalt&task=b0helpers.find_is_special
	public function find_is_special() {
//		$idPriceGeneral = '8';
//		$idPriceSimple = '46';
//		$idPriceSilver = '63';
//		$idPriceGold = '64';
		//$idIsSpecial = '145';   // Ремонт
		$idIsSpecial = '135';    // Запчасти
		//$section_id = 1;    // Ремонт
		$section_id = 2;    // Запчасти

		echo '<h3>Ищем спецпредложения</h3>';

		$db = JFactory::getDbo();
		//$db->setQuery("SELECT id, fields, title, alias FROM #__js_res_record WHERE section_id = {$section_id} AND published = 1");
		$db->setQuery("SELECT id, fields, title, alias FROM #__js_res_record WHERE section_id = {$section_id} AND published = 1 AND id IN(SELECT record_id FROM #__js_res_record_values WHERE field_id = {$idIsSpecial} AND field_value = '1')");

		$list = $db->loadObjectList();
		//b0dd($list);

		if ($list) {
			foreach ($list as $item) {
				$fields = json_decode($item->fields, TRUE);
				$url = '/spareparts/item/'.$item->id.'-'.$item->alias;
				echo '<p><a href="'.$url.'" target="_blank">'.$item->title.'</a> / '.'</p>';
			}
		}
		else {
			echo '<p>Ничего не найдено</p>';
		}
	}
	
	// Вызов - https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0helpers.find_value
	public function find_value() {
		$section_id = 1;    // Id раздела
		$field_id = '11';    // Id поля
		$field_value = "Arkana";    // Значение поля
		$field_id_2 = '55';    // Id поля
		$field_value_2 = "F4R (2.0 16V)";    // Значение поля
		$excluded_id = [5292, 5610, 5605, 4921];

		echo '<h3>Ищем ' . $field_value . '</h3>';

		$db = JFactory::getDbo();
		//$db->setQuery("SELECT id, fields, title, alias FROM #__js_res_record WHERE section_id = {$section_id} AND published = 1");
		$db->setQuery("SELECT id, fields, title, alias FROM #__js_res_record
				WHERE section_id = {$section_id} AND
				      published = 1 AND
				      id IN(SELECT record_id FROM #__js_res_record_values WHERE field_id = {$field_id} AND field_value = '{$field_value}') AND
				      id IN(SELECT record_id FROM #__js_res_record_values WHERE field_id = {$field_id_2} AND field_value = '{$field_value_2}')
				      ");

		$list = $db->loadObjectList();
		//b0dd($list);

		if ($list) {
			foreach ($list as $item) {
				$fields = json_decode($item->fields, TRUE);
				$url = '/repair/item/'.$item->id.'-'.$item->alias;
//				echo '<p><a href="'.$url.'" target="_blank">'.$item->title.'</a> / '.'</p>';
				echo $item->id . ',';
			}
		}
		else {
			echo '<p>Ничего не найдено</p>';
		}
	}

	// Вызов - /index.php?option=com_cobalt&task=b0helpers.quantity_in_orders&start=YYYY-MM-DD&end=YYYY-MM-DD
	public function quantity_in_orders() {
		$start = $_GET['start'] ?? null;
		$end = $_GET['end'] ?? null;
		$result = [];
		
		echo "<h3>Вычисляем количества в заказах c {$start} по {$end}</h3>";
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(TRUE);
		$query->select('created, data');
		$query->from('#__lscart_orders');
		if ($start) {
			$where = "created >= '{$start}'";
			if ($end) {
				$where .= " AND created <= '{$end}'";
			}
			$query->where($where);
		}
		$db->setQuery($query);
//		$db->setQuery("SELECT created, data FROM #__lscart_orders WHERE (created>='{$start}' AND created<='{$end}')");
//		$db->setQuery("SELECT created, data FROM #__lscart_orders");

		$list = $db->loadObjectList();

//		b0debug($list);
		if ($list) {
			foreach ($list as $item) {
				$data = json_decode($item->data, TRUE);
				//b0debug($data);
				if ($data !== null) {
					foreach ($data as $key=>$value) {
						//b0debug($value);
						if (array_key_exists($key, $result)) {
							$result[$key]['quantity'] += (int) $value['quantity'];
							if (isset($value['price'])) {
								$result[$key]['middle'] += (int) $value['quantity'];
								$result[$key]['price'] += (int) $value['price'];
							}
							//$result[$key]['price'] += (int) $value['price'] ?? 0;
						}
						else {
							$result[$key]['quantity'] = (int) $value['quantity'];
							if (isset($value['price'])) {
								$result[$key]['middle'] = (int) $value['quantity'];
								$result[$key]['price'] = (int) $value['price'];
							}
							else {
								$result[$key]['middle'] = 0;
								$result[$key]['price'] = 0;
							}
							$result[$key]['code'] = $value['code'];
							$result[$key]['title'] = $value['title'];
						}
					}
				}
			}
			arsort($result);
			//b0debug($result);
			foreach ($result as $k => $res) {
				$price = number_format($res['price'], 2, '.', ' ');
				if ($res['middle'] > 0) {
					$middle = number_format($res['price'] / $res['middle'], 2, '.', ' ');
				}
				echo '<p>'.$res['code'].' / '.$res['title'].' --> '.$res['quantity'].' / '.$res['middle'].' шт. = '.$price.' руб., средняя цена - '.$middle.' руб.</p>';
				//echo '<p>'.$res['code'].' / '.$res['title'].' -> '.$res['quantity'].' шт. = '.'</p>';

			}
		}
		else {
			echo '<p>Ничего не найдено</p>';
		}
	}
}
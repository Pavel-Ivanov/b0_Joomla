<?php
defined('_JEXEC') or die();
JImport('b0.Yml.Yml');
JImport('b0.fixtures');

/**
 * Class CobaltControllerB0Yml
 *
 * https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0yml.create
 *
 * /usr/bin/wget -O - -q /dev/null "https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0yml.create"
 */
class CobaltControllerB0Yml extends JControllerAdmin
{
	public $yml;
	
	public function create()
	{
		$this->yml = new Yml();
		
		$resYMarket = $this->yml->renderYMarketFile();
		$resYFull = $this->yml->renderYFullFile();
		JExit("Файлы сформированы");
/*		if ($this->yml->renderYMarketFile()) {
			JExit("Файл Yandex Market сформирован");
		}
		else {
			JExit("Файл Yandex Market не сформирован");
		}
		
		if ($this->yml->renderYFullFile()) {
			JExit("Файл Yandex Full сформирован");
		}
		else {
			JExit("Файл Yandex Full не сформирован");
		}*/
	}
}

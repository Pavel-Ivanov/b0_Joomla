<?php
defined('_JEXEC') or die;

include_once JPATH_ROOT.'/components/com_cobalt/api.php';
//Ссылка для запуска https://logan-shop.spb.ru/index.php?option=com_cobalt&task=b0sitemap.createsitemap

class CobaltControllerB0SiteMap extends JControllerAdmin
{
    protected $file_path = "/sitemap.xml";
    protected $file_handle;
    protected $logs = [];
    protected $map_items = array();
    protected $menuParams = array(
        //Главная
         'home' => array(
             'type' => 'link',
             'item_id' => '',
             'loc' => '',
             'priority' => '1',
             'changefreq' => 'weekly'
         ),
        //Запчасти
         'catalog' => array(
             'type' => 'section',
             'item_id' => 2,
             'loc' => '/spareparts',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
        // Аксессуары
         'accessories' => array(
             'type' => 'section',
             'item_id' => 12,
             'loc' => '/accessories',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
	    //Доставка
         'delivery' => array(
	         'type' => 'link',
	         'item_id' => '2326',
	         'loc' => '/delivery',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),
	    //Чип-тюнинг
         'chip-tuning' => array(
	         'type' => 'link',
	         'item_id' => '6176',
	         'loc' => '/chip-tuning',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),
	    //Ремонт
         'repair' => array(
             'type' => 'section',
             'item_id' => 1,
             'loc' => '/repair',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
	    //Гарантия
         'guarantee' => array(
	         'type' => 'link',
	         'item_id' => '3862',
	         'loc' => '/repair/guarantee',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),
         //Техобслуживание
         'maintenance' => array(
             'type' => 'section',
             'item_id' => 8,
             'loc' => '/maintenance',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
         //Доп. оборудование
         'bundles' => array(
             'type' => 'section',
             'item_id' => 11,
             'loc' => '/bundles',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
	     //Скидки и акции
	     //Текущие акции
/*         'tekushchie-aktsii' => array(
	         'type' => 'section',
	         'item_id' => 13,
	         'loc' => '/discounts/tekushchie-aktsii',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),*/
	    //Дисконтные карты
         'discount-cards' => array(
	         'type' => 'link',
	         'item_id' => '2331',
	         'loc' => '/discounts/discount-cards',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),
	    //График работы
         'grafik-raboty' => array(
	         'type' => 'link',
	         'item_id' => '5661',
	         'loc' => '/discounts/grafik-raboty',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),
	    //Новости
         'news' => array(
             'type' => 'section',
             'item_id' => 7,
             'loc' => '/news',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
        //Полезное
         'helpful' => array(
             'type' => 'section',
             'item_id' => 4,
             'loc' => '/helpful',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
	    //Контакты
         'contacts' => array(
	         'type' => 'link',
	         'item_id' => '2664',
	         'loc' => '/contacts',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),
	    //Партнеры
	    //Наши партнеры
/*         'our-partners' => array(
	         'type' => 'section',
	         'item_id' => 14,
	         'loc' => '/partners/our-partners',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),*/
	    //Партнерская программа
         'partners-programm' => array(
	         'type' => 'link',
	         'item_id' => '5724',
	         'loc' => '/partners/partners-programm',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),
	    //О нас
	    //Сотрудники
/*         'employees' => array(
             'type' => 'section',
             'item_id' => 10,
             'loc' => '/about-us/employees',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),*/
	    //Вакансии
/*         'vacancies' => array(
	         'type' => 'section',
	         'item_id' => 15,
	         'loc' => '/about-us/vacancies',
	         'priority' => '0.8',
	         'changefreq' => 'weekly'
         ),*/
	    //Пользовательское соглашение
         'terms-of-use' => array(
             'type' => 'link',
             'item_id' => '3862',
             'loc' => '/about-us/terms-of-use',
             'priority' => '0.8',
             'changefreq' => 'weekly'
         ),
    );

     public function createSiteMap() {

         $this->file_handle = fopen(JPATH_ROOT . $this->file_path, "w+t");

         if ($this->file_handle == false) {
             $this->logs[] = 'Logan-Shop SiteMap - Ошибка открытия файла sitemap.xml';
             return;
         }
         $title = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
             '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

         $res = fwrite($this->file_handle, $title);
         if ($res == false) {
             $this->logs[] = 'Logan-Shop SiteMap - Ошибка записи в файл sitemap.xml';
             fclose($this->file_handle);
             return;
         };

         foreach ($this->menuParams as $item) {
             switch ($item['type']) {
                 case 'link':
                     $this->add_link($item);
                     break;
                 case 'section':
                     $this->add_section($item);
                     break;
             }
         }
         $this->render_map_items();

         $footer = '</urlset>';
         $res = fwrite($this->file_handle, $footer);
         if ($res == false) {
             $this->logs[] = 'Logan-Shop SiteMap - Ошибка записи в файл sitemap.xml';
             fclose($this->file_handle);
             return;
         };

         $this->logs[] = 'Карта сайта Logan-Shop сформирована';
         $this->sendMail($this->logs);
     }

    private function add_link($item) {
         $node = new stdclass();
         $node->loc = 'https://logan-shop.spb.ru' . $item['loc'];
         $node->priority = $item['priority'];
         $node->changefreq = $item['changefreq'];
         $this->map_items[] = $node;
         return true;
    }

    private function add_section($item) {
        $node = new stdclass();
        $node->loc = 'https://logan-shop.spb.ru' . $item['loc'];
        $node->priority = $item['priority'];
        $node->changefreq = $item['changefreq'];
        $this->map_items[] = $node;

        // добавляем категории из секции
        $this->addCategories($item);

        // добавляем статьи из секции
        $this->addItems($item);

        return true;
    }

    private function render_map_items() {
         foreach ($this->map_items as $node){
             $node_content = '<url>' . "\n";
             $node_content .= '<loc>' . $node->loc . '</loc>' . "\n";
             $node_content .= '<priority>' . $node->priority . '</priority>' . "\n";
             $node_content .= '<changefreq>' . $node->changefreq . '</changefreq>' . "\n";
             $node_content .= '</url>' . "\n";
             $res = fwrite($this->file_handle, $node_content);
             if ($res == false) {
                 $this->logs[] = 'Logan-Shop SiteMap - Ошибка записи в файл sitemap.xml';
                 fclose($this->file_handle);
                 return false;
             };
         }
         return true;
    }

     private function addCategories ($item) {

         $db = JFactory::getDbo();
         $query = $db->getQuery(TRUE);
         $query->select('id, title, alias, path, section_id, published');
         $query->from('#__js_res_categories');
         $query->where('section_id = ' . $item['item_id']);
         $query->where('published = 1');
         //$query->order("lft");
         $db->setQuery($query);
         $items = $db->loadObjectList();

         if(!empty($items)) {
             foreach($items as $item)
             {
                 $node = new stdclass();
                 $node->loc = 'https://logan-shop.spb.ru' . JRoute::_(Url::records($item->section_id, $item->id));
                 $node->priority = '0.7';
                 $node->changefreq = 'weekly';
                 $this->map_items[] = $node;
             }
         }
         return true;
     }

    private function addItems ($item) {

        $db = JFactory::getDbo();
        $query = $db->getQuery(TRUE);
        $query->select('id, title, alias, section_id, type_id, published, categories');
        $query->from('#__js_res_record');
        $query->where('section_id = ' . $item['item_id']);
        $query->where('published = 1');
        //$query->order("lft");
        $db->setQuery($query);
        $items = $db->loadObjectList();

        if(!empty($items)) {
            foreach($items as $item)
            {
                $type = ItemsStore::getType($item->type_id);
                $section = ItemsStore::getSection($item->section_id);
                $cats = array_keys(json_decode($item->categories, TRUE));
                $cat_id = array_shift($cats);
                $node = new stdclass();
//                $node->loc = 'https://logan-shop.spb.ru' . JRoute::_(Url::record($item->id, $type, $section, $cat_id));
                $node->loc = 'https://logan-shop.spb.ru' . JRoute::_(Url::record($item->id, $type, $section));
                $node->priority = '0.5';
                $node->changefreq = 'weekly';

                $this->map_items[] = $node;
            }
        }
        return true;
    }

    /**
     * @param array $logs
     */
    private function sendMail(array $logs) {
        $messageBody = '';
        foreach ($logs as $log) {
            $messageBody .= $log . "\n";
        }
        $result = JFactory::getMailer()->sendMail('admin@logan-shop.spb.ru', 'Admin', 'p.ivanov@logan-shop.spb.ru', 'Logan-Shop SiteMap', $messageBody, TRUE);
    }
}
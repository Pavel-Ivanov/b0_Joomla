<?php
defined('_JEXEC') or die();
JImport('b0.Item.Item');
//JImport('b0.Accessory.Accessory');
//JImport('b0.Accessory.AccessoryKeys');
JImport('b0.Accessory.AccessoryIds');
JImport('b0.pricehelper');
JImport('b0.openGraphHelper');
JImport('b0.fixtures');

$host = JUri::root();
$item = $this->item;
$item_id = $item->id;
$app = JFactory::getApplication();
$siteName = $app->get('sitename');
$cart = $app->getUserState('cart') ?? [];
$in_cart = array_key_exists($item_id, $cart);
$quant = ($in_cart) ? $cart[$item_id]['quantity'] : 0;

$user = $this->user;
/** @var JRegistry $paramsRecord */
$paramsRecord = $this->tmpl_params['record'];
// Open Graph
echo JLayoutHelper::render('b0.openGraph', [
	'og' => setOpenGraph($item,
		$item->fields_by_id[AccessoryIds::ID_IMAGE] ?? null,
		$item->fields_by_id[AccessoryIds::ID_GALLERY] ??  null,
		$item->fields_by_id[AccessoryIds::ID_VIDEO] ?? null),
	'doc' => $this->document,
]);

/** @var boolean $is_special */
$is_special = ($item->fields_by_id[AccessoryIds::ID_IS_SPECIAL]->value == 1) ? true : false;

/** @var boolean $is_by_order */
$is_by_order = ($item->fields_by_id[AccessoryIds::ID_IS_BY_ORDER]->value == 1) ? true : false;

/** @var boolean $is_general */
$is_general = (!$is_special && !$is_by_order) ? true : false;

/** @var boolean $is_original */
$is_original = $item->fields_by_id[AccessoryIds::ID_IS_ORIGINAL]->value == 1 ? true : false;

$prices = [
	'general'=> $item->fields_by_id[AccessoryIds::ID_PRICE_GENERAL]->value,
    'special'=> isset($item->fields_by_id[AccessoryIds::ID_PRICE_SPECIAL]) ? ($item->fields_by_id[AccessoryIds::ID_PRICE_SPECIAL]->value) : 0,
    'simple'=> $item->fields_by_id[AccessoryIds::ID_PRICE_SIMPLE]->value,
    'silver'=> $item->fields_by_id[AccessoryIds::ID_PRICE_SILVER]->value,
    'gold'=> $item->fields_by_id[AccessoryIds::ID_PRICE_GOLD]->value,
    'delivery'=> $item->fields_by_id[AccessoryIds::ID_PRICE_DELIVERY]->value
];

$this->document->setTitle($item->title.' купить в '. $siteName);
//TODO добавить спецпредложение
$descr = 'Вы можете купить '. $item->title . ' по доступной цене в магазинах ' . $siteName . '. ' .
	$item->title . '- описание, фото, характеристики, аналоги, сопутствующие товары и отзывы покупателей.';
$this->document->setMetaData('description', $descr);
?>
<?php $microdata = new JMicrodata('Product');?>
<div <?= $microdata::htmlProperty('Product');?> <?= $microdata::htmlScope('Product')?> >
    <?= $microdata::htmlMeta($item->title, 'name');?>
    <?= $microdata::htmlMeta($descr, 'description');?>
    <?= $microdata::htmlMeta(JUri::base() . $item->fields_by_id[AccessoryIds::ID_IMAGE]->value['image'], 'image');?>
    <div <?= $microdata::htmlProperty('offers');?> <?= $microdata::htmlScope('Offer')?> >
        <?php
        if ($is_by_order) {
	        echo JMicrodata::htmlMeta($prices['general'], 'price');
        }
        elseif ($is_special) {
            echo JMicrodata::htmlMeta($prices['special'], 'price');
        }
        else {
            echo JMicrodata::htmlMeta($prices['general'], 'price');
        } ?>
        <?= JMicrodata::htmlMeta('InStock', 'availability');?>
        <?= $microdata::htmlMeta(JRoute::_($item->url, TRUE, 1), 'url');?>
        <?= $microdata::htmlMeta('RUB', 'priceCurrency');?>
        <?= $microdata::htmlMeta('2019-12-31', 'priceValidUntil');?>
	    <?= $microdata::htmlMeta('Наличные, Кредитная карта', 'acceptedPaymentMethod');?>
	    <?= $microdata::htmlMeta('Бесплатная доставка', 'availableDeliveryMethod');?>
	    <?= $microdata::htmlMeta('12 месяцев', 'warranty');?>
    </div>
	<?php if (isset($item->fields_by_id[AccessoryIds::ID_MANUFACTURER])){
		echo $microdata::htmlMeta($item->fields_by_id[AccessoryIds::ID_MANUFACTURER]->result, 'manufacturer');
	}?>
	<?php if (isset($item->fields_by_id[AccessoryIds::ID_ORIGINAL_CODE])){
		echo $microdata::htmlMeta($item->fields_by_id[AccessoryIds::ID_ORIGINAL_CODE]->raw, 'mpn');
	}?>
	<?php if (isset($item->fields_by_id[AccessoryIds::ID_PRODUCT_CODE])){
		echo $microdata::htmlMeta($item->fields_by_id[AccessoryIds::ID_PRODUCT_CODE]->raw, 'sku');
	}?>
    <div itemprop="brand"  itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="<?= $siteName;?>" />
        <meta itemprop="address" content="Санкт-Петербург, ул. Седова, 13" />
        <meta itemprop="telephone" content="(812) 928-32-27, (812) 928-32-62, (800) 234-32-27" />
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <meta itemprop="url" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="image" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="height" content="80px" />
            <meta itemprop="width" content="170px" />
        </div>
    </div>
</div>

<article class="uk-article">
<?php if($item->controls):
    echo JLayoutHelper::render('b0.controls', $item->controls);
endif;?>

<h1 class="uk-text-center-small"><?= $item->title;?></h1>

<div class="uk-navbar">
    <div class="uk-navbar-nav">
        <?php if (isset($item->fields_by_id[AccessoryIds::ID_SUBTITLE])) :?>
            <p class="uk-article-lead"><?= $item->fields_by_id[AccessoryIds::ID_SUBTITLE]->result;?></p>
        <?php endif; ?>
    </div>
    <div class="uk-navbar-flip">
        <?php if (isset($item->fields_by_id[AccessoryIds::ID_PRODUCT_CODE])) :?>
            <p><strong>Код товара: <?= $item->fields_by_id[AccessoryIds::ID_PRODUCT_CODE]->result;?></strong></p>
        <?php endif;?>
    </div>
</div>

<div class="uk-grid" data-uk-grid-match>
    <div class="uk-width-medium-2-5 uk-text-center"> <!-- Картинка -->
        <?php if (isset($item->fields_by_id[AccessoryIds::ID_IMAGE])) echo $item->fields_by_id[AccessoryIds::ID_IMAGE]->result;?>
    </div>

    <div class="uk-width-medium-3-5">
        <!-- Блок цен -->
        <?php
        if ($is_by_order) {
            echo '<p class="ls-price-first">Ожидается поступление</p>';
            echo '<p class="ls-price-second">Цена уточняется при заказе</p>';
        }
        elseif ($is_special) {
            echo '<p class="ls-price-special uk-text-danger uk-margin-top">';
            echo 'Специальная цена: ' . render_price($prices['special']);
            echo '</p>';
            echo '<p class="ls-price-second uk-margin-top">Обычная цена: <del>'.
                render_price($prices['general']).
                '</del></p>';
            echo '<p class="uk-margin-top">'.
                'Вы экономите ' . render_economy($prices['general'], $prices['special']).
                '</p>';
        }
        else {
            echo '<p class="ls-price-first uk-text-center-small uk-margin-top">';
            echo 'Цена: ' . render_price($prices['general']);
            echo '</p>';
        } ?>
        <!-- Блок доставки и корзины -->
        <?php
        if (!$is_by_order) {?>
            <div class="uk-panel uk-panel-box uk-margin-top">
                <!-- Блок доставки -->
                <?php
                if ($is_general) { ?>
                    <p class="uk-text-danger ls-price-first">Цена при доставке по СПб: <?= render_price($prices['delivery']);?></p>
                    <p>
                        <?= 'Вы экономите ' . render_economy($prices['general'], $prices['delivery']);?>
                    </p>
                <?php }?>
                <!-- Блок корзины -->
                <div id="cart<?= $item_id;?>" class="uk-vertical-align-middle">
                    <input type="number" id="cart-quantity<?= $item_id;?>"
                        <?= !$in_cart ? 'min="1"' : 'min="0"';?>
                        <?= !$in_cart ? 'value="1"' : 'value="0"';?>
                           style="margin-bottom: auto; width: 50px;" />
                    <button type="button" class="cart-add" id="cart-add<?= $item_id;?>"
                            data-item-id = "<?= $item_id;?>"
                            data-in-cart="<?= $in_cart ? $in_cart : 0;?>">
                        <?= $in_cart ? 'Изменить' : '<i class="uk-icon-cart-plus uk-margin-right"></i>Добавить в корзину';?>
                    </button>
                    <a href="<?= JRoute::_('cart'); ?>" rel="nofollow">
                            <span id="cart-already<?= $item_id;?>" <?= (!$in_cart) ? "hidden" : "";?>>Сейчас в корзине
                                <span class="badge" style="font-size: 15px;" ><?= $quant;?></span></span>
                    </a>
                </div>
                <!-- Блок параметров доставки -->
                <div class="uk-margin-top">
                    <p>
                        <strong>Доставка:</strong> завтра
                    </p>
                    <p>
                        <strong>Оплата:</strong>
                        <i class="uk-icon-money" data-uk-tooltip title="Оплата наличными"></i> наличные,
                        <i class="uk-icon-credit-card" data-uk-tooltip title="Оплата кредитной картой"></i> кредитная карта
                    </p>
                    <p>
                        <strong>Закажите по телефонам: </strong>
                        <a class="uk-h5" href="tel:+79111998979">8-911-199-89-79</a>
                        или
                        <a class="uk-h5" href="tel:+78002343227">8-800-234-32-27</a>
                    </p>
                </div>
                <!-- Блок заказа звонка -->
                <div class="uk-grid">
                    <div class="uk-width-medium-1-2">
                        <i class="uk-icon-question-circle uk-margin-right"></i>
                        <a href="<?= $paramsRecord->get('tmpl_core.delivery_url');?>" target="_blank" title="Посмотреть условия доставки">
                            Условия доставки
                        </a>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <i class="uk-icon-phone uk-margin-right"></i>
                        <a class="contactus-<?= $paramsRecord->get('tmpl_core.module_1');?>" href="#" title="Мы перезвоним Вам в течение часа в рабочее время">
                            Заказать обратный звонок
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<div class="uk-grid" data-uk-grid-match>
    <div class="uk-width-medium-2-5">
        <div class="uk-panel uk-panel-box uk-panel-box-secondary">
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_MANUFACTURER])){
                render_field($item->fields_by_id[AccessoryIds::ID_MANUFACTURER], $user);
            }?>
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_VENDOR_CODE])){
                render_field($item->fields_by_id[AccessoryIds::ID_VENDOR_CODE], $user);
            }?>
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_ORIGINAL_CODE])){
                render_field($item->fields_by_id[AccessoryIds::ID_ORIGINAL_CODE], $user, 'mpn');
            }?>
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_MODEL])){
                render_field($item->fields_by_id[AccessoryIds::ID_MODEL], $user);
            }?>
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_MOTOR])){
                render_field($item->fields_by_id[AccessoryIds::ID_MOTOR], $user);
            }?>
        </div>
    </div>
    <div class="uk-width-medium-3-5">
        <div class="uk-panel uk-panel-box uk-panel-box-secondary">
           <!-- Блок цен по дисконтным картам -->
            <?php if ($is_general) { ?>
                <div class="accordion" id="prices-to-cards">
                    <div class="accordion-group" style="border: 0;">
                        <div class="uk-h4 accordion-heading">
                            <a class="accordion-toggle" style="padding-left: 0;" data-toggle="collapse"
                               data-parent="#prices-to-cards" href="#collapse1"
                               title="Посмотреть цены с учетом скидок по дисконтной карте">
                                <i class="uk-icon-gift uk-icon-medium uk-margin-right"></i>
                                Посмотреть цены по дисконтной карте
                            </a>
                        </div>
                        <div id="collapse1" class="accordion-body collapse">
                            <div class="uk-grid" data-uk-grid-margin>
                                <div class="uk-width-medium-1-3 uk-panel-teaser">
                                    <img src="<?= $paramsRecord->get('tmpl_core.discount_card_icon');?>" alt="Дисконтная карта <?= $siteName;?>" />
                                </div>
                                <div class="uk-width-medium-2-3 uk-text-center-small">
                                    <p class="uk-h5 uk-margin-top">Стандартный уровень- <span class="uk-h4"><?= render_price($prices['simple']);?></span></p>
                                    <p class="uk-h5">Серебряный уровень- <span class="uk-h4"><?= render_price($prices['silver']);?></span></p>
                                    <p class="uk-h5">Золотой уровень- <span class="uk-h4"><?= render_price($prices['gold']);?></span></p>
                                    <p>
                                        <a href="<?= $paramsRecord->get('tmpl_core.discounts_url');?>" target="_blank" title="Программа лояльности <?= $siteName;?>">
                                            <i class="uk-icon-exclamation-circle uk-margin-right"></i>
                                            Программа лояльности <?= $siteName;?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Наличие Седова -->
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_SEDOVA])) {
                render_field($item->fields_by_id[AccessoryIds::ID_SEDOVA], $user);
            }?>
            <!-- Наличие Химиков -->
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_KHIMIKOV])) {
                render_field($item->fields_by_id[AccessoryIds::ID_KHIMIKOV], $user);
            }?>
            <!-- Наличие Жукова -->
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_ZHUKOVA])) {
                render_field($item->fields_by_id[AccessoryIds::ID_ZHUKOVA], $user);
            }?>
            <!-- Наличие Культуры -->
            <?php if (isset($item->fields_by_id[AccessoryIds::ID_KULTURY])) {
                render_field($item->fields_by_id[AccessoryIds::ID_KULTURY], $user);
            }?>
        </div>
    </div>
</div>

<hr class="uk-article-divider">
<!-- Описание -->
<div>
    <?php if (isset($item->fields_by_id[AccessoryIds::ID_DESCRIPTION])) echo $item->fields_by_id[AccessoryIds::ID_DESCRIPTION]->result; ?>
</div>
<!-- Галерея -->
<?php if (isset($item->fields_by_id[AccessoryIds::ID_GALLERY])) {
    echo '<hr class="uk-article-didider">';
    echo $item->fields_by_id[AccessoryIds::ID_GALLERY]->result;
} ?>
<!-- Видео -->
<?php if (isset($item->fields_by_id[AccessoryIds::ID_VIDEO])) {
    echo '<hr class="uk-article-didider">';
    echo $item->fields_by_id[AccessoryIds::ID_VIDEO]->result;
} ?>
<!-- Статистика -->
<div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-top">
    <div class="uk-flex uk-flex-middle uk-flex-space-between">
        <div class="uk-text-small">
	        <?= JLayoutHelper::render('b0.hits', ['hits' => $item->hits]);?>
        </div>
        <div>
	        <?= JLayoutHelper::render('b0.rating', ['rating' => $item->rating]);?>
        </div>
        <div>
            <?= JLayoutHelper::render('b0.discuss', ['href' => $paramsRecord->get('tmpl_core.vk_url'), 'src' => $paramsRecord->get('tmpl_core.vk_icon')]);?>
        </div>
        <div>
	        <?= JLayoutHelper::render('b0.social');?>
        </div>
    </div>
</div>

<!-- Закладки -->
<div class="uk-margin uk-width-medium-1-1">
    <!-- Заголовки закладок -->
    <ul class="uk-tab" data-uk-tab="{connect:'#tab-content'}">
        <?php
             if (isset($item->fields_by_id[AccessoryIds::ID_CHARACTERISTICS])) {tab_title("Характеристики", 1);}
             if (isset($item->fields_by_id[AccessoryIds::ID_ANALOGS])) {tab_title("Аналоги", 0);}
             if (isset($item->fields_by_id[AccessoryIds::ID_ASSOCIATED])) {tab_title("Сопутствующие", 0);}
             if (isset($item->fields_by_id[AccessoryIds::ID_WORKS])) {tab_title("Автосервис", 0);}
//             if (isset($item->fields_by_id[AccessoryIds::ID_FOR_READING])) {tab_title("Почитать", 0);}
        ?>
    </ul>
    <!-- Контент закладок -->
    <ul class="uk-switcher uk-margin" id="tab-content">
        <?php
            if (isset($item->fields_by_id[AccessoryIds::ID_CHARACTERISTICS])) {tab_content($item->fields_by_id[AccessoryIds::ID_CHARACTERISTICS]->result);}
            if (isset($item->fields_by_id[AccessoryIds::ID_ANALOGS])) {tab_content($item->fields_by_id[AccessoryIds::ID_ANALOGS]->result);}
            if (isset($item->fields_by_id[AccessoryIds::ID_ASSOCIATED])) {tab_content($item->fields_by_id[AccessoryIds::ID_ASSOCIATED]->result);}
            if (isset($item->fields_by_id[AccessoryIds::ID_WORKS])) {tab_content($item->fields_by_id[AccessoryIds::ID_WORKS]->result);}
//            if (isset($item->fields_by_id[AccessoryIds::ID_FOR_READING])) {tab_content($item->fields_by_id[AccessoryIds::ID_FOR_READING]->result);}
        ?>
    </ul>
</div>
<!-- Конец закладок -->
<hr class="uk-article-divider">
<noindex>
    <div>{module <?= $paramsRecord->get('tmpl_core.module_2');?>}</div>
    <div class="uk-margin-large-top uk-margin-large-bottom">
        Вы можете купить <?= $item->title;?> в магазинах <?= $siteName;?> по доступной цене.
        <?= $item->title; ?>: описание, фото, характеристики, аналоги, сопутствующие товары и отзывы покупателей.
    </div>
</noindex>

</article>

<script>
    'use strict';
    let elem = document.getElementsByClassName('cart-add');
    for (let i = 0; i < elem.length; i++) {
        elem[i].addEventListener('click' , cartAdd);
    }

    function cartAdd(event) {
        let target = event.target;
        //Аналитика
        let yandex = <?= $paramsRecord->get('tmpl_core.yandex');?>;
        let yandexId = typeof <?= $paramsRecord->get('tmpl_core.yandex_id');?>;
        let yandexGoal = '<?= $paramsRecord->get('tmpl_core.yandex_goal');?>';
        let google = <?= $paramsRecord->get('tmpl_core.google');?>;
        let googleGoal = '<?= $paramsRecord->get('tmpl_core.google_goal');?>';
        //Получаем значения ID элемента и количества
        let itemId = target.getAttribute("data-item-id");
        let formQuantity = document.getElementById('cart-quantity'+itemId);
        let itemQuantity = formQuantity.value;
        let inCart = target.getAttribute("data-in-cart");

        target.innerHTML = '<i class="uk-icon-refresh uk-icon-spin"></i>';
        let xhr = new XMLHttpRequest();
        let body = '';
        let task = '';
        if (itemQuantity === '0') { // Удаляем
            body = 'item_id='+itemId;
            task = 'index.php?option=com_lscart&task=cart.delete';
        }
        else {  // Изменяем
            body = 'item_id='+itemId+'&item_quantity='+itemQuantity;
            task = 'index.php?option=com_lscart&task=cart.add';
        }

        xhr.open("POST", task, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(body);

        xhr.onreadystatechange = function() {
            if (this.readyState !== 4) {
                return;
            }

            if (xhr.status !== 200) {
                alert(xhr.status + ': ' + xhr.statusText);
            }
            else {
                // Отправка аналитики
                if (yandex === 1) {
                    if (yandexId !== "undefined" && yandexId !== null) {
                        let isYandex = <?= $paramsRecord->get('tmpl_core.yandex_id');?>;
                        isYandex.reachGoal(yandexGoal);
                    }
                }
                if (google === 1) {
                    if (typeof dataLayer !== "undefined" && dataLayer !== null) {
                        dataLayer.push({"event": googleGoal});
                    }
                }
                //Кнопка - target
                target.setAttribute("data-in-cart", itemQuantity);
                if (itemQuantity === '0') { //Удаляем
                    target.innerHTML = '<i class="uk-icon-cart-plus uk-margin-right"></i>Добавить в корзину';
                }
                else {  // Изменяем
                    target.innerHTML = 'Изменить';
                }

                //Уже в корзине- cartAlready
                let cartAlready = document.getElementById('cart-already'+itemId);
                if (itemQuantity === '0') { // Удаляем
                    cartAlready.hidden = true;

                }
                else {  // Изменяем
                    cartAlready.lastChild.textContent = formQuantity.value;
                    cartAlready.hidden = false;
                }

                //Модуль корзины
                let elemCartCount = document.getElementById('cart-count');
                let elemCartCountSmall = document.getElementById('cart-count-small');

                if (itemQuantity === '0') {
                    elemCartCount.textContent = String(Number(elemCartCount.textContent) - 1);
                    elemCartCountSmall.textContent = String(Number(elemCartCountSmall.textContent) - 1);
                }
                else {
                    if (inCart === '0') {   // Это новый элемент в корзине
                        elemCartCount.textContent = String(Number(elemCartCount.textContent) + 1);
                        elemCartCountSmall.textContent = String(Number(elemCartCountSmall.textContent) + 1);
                    }
                }

                //Количество- itemQuantity, определено выше
                if (itemQuantity === '0') { // Удаляем
                    document.getElementById('cart-quantity'+itemId).value = 1;
                    document.getElementById('cart-quantity'+itemId).setAttribute('min', 1);
                }
                else {  // Изменяем
                    document.getElementById('cart-quantity'+itemId).value = 0;
                    document.getElementById('cart-quantity'+itemId).setAttribute('min', 0);
                }
            }
        }
    }
</script>

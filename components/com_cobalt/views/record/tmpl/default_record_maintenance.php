<?php
defined('_JEXEC') or die();
JImport('b0.Item.Item');
JImport('b0.Maintenance.Maintenance');
JImport('b0.fixtures');
$params = $this->tmpl_params['record'];
//b0debug($params);
//b0debug($params->get('tmpl_params.item_time_format'));
//b0debug($params->get('tmpl_core.vk_url'));

$maintenance = new Maintenance($this->item);
//unset($this->item);
//b0debug($maintenance);

$this->document->setTitle($maintenance->metaTitle);
$this->document->setMetaData('description', $maintenance->metaDescription);
JLayoutHelper::render('b0.openGraph', ['og' => $maintenance->openGraph, 'doc' => $this->document]);
?>

<article class="uk-article" itemscope itemtype="https://schema.org/Product">

    <meta itemprop="name" content="<?= $maintenance->title;?> за <?= $maintenance->worksSum;?> рублей">
    <meta itemprop="description" content="<?= $maintenance->metaDescription;?>">
    <meta itemprop="sku" content="<?= $maintenance->serviceCode;?>">
    <meta itemprop="mpn" content="<?= $maintenance->serviceCode;?>">
    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
        <meta itemprop="price" content="<?= $maintenance->worksSum;?>"/>
        <meta itemprop="priceCurrency" content="RUB" />
        <meta itemprop="priceValidUntil" content="2019-12-31" />
        <meta itemprop="acceptedPaymentMethod" content="Наличные, Кредитная карта"/>
        <meta itemprop="warranty" content="12 месяцев"/>
        <meta itemprop="availability" content="InStock"/>
        <meta itemprop="url" content="<?= JRoute::_($this->item->url, TRUE, 1);?>"/>
    </div>
    <div itemprop="brand"  itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="<?= $maintenance->siteName;?>" />
        <meta itemprop="address" content="Санкт-Петербург, ул. Седова, 13" />
        <meta itemprop="telephone" content="(812) 928-32-27, (812) 928-32-62, (800) 234-32-27" />
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <meta itemprop="url" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="image" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="height" content="80px" />
            <meta itemprop="width" content="170px" />
        </div>
    </div>


    <?php if($maintenance->controls){
		echo JLayoutHelper::render('b0.controls', $maintenance->controls);
	}?>

    <header>
		<?php $maintenance->renderTitle();?>
    </header>

    <hr class="uk-article-divider uk-margin-large-bottom">

    <!-- Перечень работ -->
    <div class="uk-panel uk-panel-box">
        <h2>Перечень основных работ</h2>
    </div>
    <div class="uk-overflow-container">
        <?php $maintenance->renderWorksList();?>
    </div>
    <!-- Конец Перечень работ -->

    <!-- Перечень запчастей -->
    <div class="uk-panel uk-panel-box uk-margin-large-top">
        <h2>Перечень популярных запчастей</h2>
    </div>
    <div class="uk-overflow-container">
	    <?php $maintenance->renderSparepartsList();?>
    </div>
    <!-- Конец Перечень запчастей -->

    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-top">
        <p class="uk-h2 uk-align-right">
            <button type="button" class="uk-button uk-button-success uk-button-large uk-margin-large-right contactus-<?= $params->get('tmpl_core.module_1');?>">
                Записаться на ТО-<?= $maintenance->workNumber;?> <?= $maintenance->models;?>
            </button>
	        <?php $maintenance->renderTotalSum();?>
        </p>
	    <?php $maintenance->renderExecutionTime();?>
    </div>

    <p class="uk-h4">Внимание!</p>
    <ul>
        <li>Цены указаны без учета скидок по дисконтным картам.</li>
        <li>Стоимость комплекта запасных частей может меняться в зависимости от Ваших пожеланий.</li>
        <li>Наличие запчастей уточняйте при записи на автосервис.</li>
        <li>Более 2500 наименований запчастей на складе.</li>
        <li>Наши менеджеры помогут подобрать запчасти по Вашим требованиям (оригиналы или аналоги).</li>
    </ul>

	<?php $maintenance->renderDescription();?>
	<?php $maintenance->renderGallery();?>
	<?php $maintenance->renderVideo();?>

    <div>{module <?= $params->get('tmpl_core.module_2');?>}</div>
    <!-- Статистика -->
    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-top">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            <div class="uk-text-small">
				<?= JLayoutHelper::render('b0.hits', ['hits' => $maintenance->hits]);?>
            </div>
            <div>
				<?= JLayoutHelper::render('b0.rating', ['rating' => $maintenance->rating]);?>
            </div>
            <div>
				<?= JLayoutHelper::render('b0.discuss', ['href' => $params->get('tmpl_core.vk_url'), 'src' => $params->get('tmpl_core.vk_icon')]);?>
            </div>
            <div>
				<?= JLayoutHelper::render('b0.social');?>
            </div>
        </div>
    </div>
</article>
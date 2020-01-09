<?php
defined('_JEXEC') or die();
JImport('b0.Item.Item');
JImport('b0.Bundle.Bundle');
JImport('b0.fixtures');
//$params = $this->tmpl_params['record'];

$bundle = new Bundle($this->item, $this->user);
//unset($this->item);
//b0debug($bundle);

$this->document->setTitle($bundle->metaTitle);
$this->document->setMetaData('description', $bundle->metaDescription);
JLayoutHelper::render('b0.openGraph', ['og' => $bundle->openGraph, 'doc' => $this->document]);
?>

<article class="uk-article" itemscope itemtype="https://schema.org/Product">

    <meta itemprop="name" content="<?= $bundle->title;?> за <?= $bundle->discountSum;?> рублей">
    <meta itemprop="description" content="<?= $bundle->metaDescription;?>">
    <meta itemprop="sku" content="<?= $bundle->productCode;?>">
    <meta itemprop="mpn" content="<?= $bundle->productCode;?>">
    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
        <meta itemprop="price" content="<?= $bundle->discountSum;?>"/>
        <meta itemprop="priceCurrency" content="RUB" />
        <meta itemprop="priceValidUntil" content="2019-12-31" />
        <meta itemprop="acceptedPaymentMethod" content="Наличные, Кредитная карта"/>
        <meta itemprop="warranty" content="12 месяцев"/>
        <meta itemprop="availability" content="InStock"/>
        <meta itemprop="url" content="<?= JRoute::_($this->item->url, TRUE, 1);?>"/>
    </div>
    <div itemprop="brand"  itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="<?= $bundle->siteName;?>" />
        <meta itemprop="address" content="Санкт-Петербург, ул. Седова, 13" />
        <meta itemprop="telephone" content="(812) 928-32-27, (812) 928-32-62, (800) 234-32-27" />
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <meta itemprop="url" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="image" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="height" content="80px" />
            <meta itemprop="width" content="170px" />
        </div>
    </div>


    <?php if($bundle->controls):
        echo JLayoutHelper::render('b0.controls', $bundle->controls);
	endif;?>

    <header>
		<?php $bundle->renderTitle();?>
    </header>

    <hr class="uk-article-divider">

    <div class="uk-grid" data-uk-grid-match>
        <div class="uk-width-medium-2-5 uk-text-center"> <!-- Картинка -->
	        <?php $bundle->renderImage();?>
        </div>

        <div class="uk-width-medium-3-5">
            <p class="uk-text-danger ls-price-first">
                Цена со скидкой <?= $bundle::TOTAL_DISCOUNT_PERCENT;?>%: <?php $bundle->renderPrice($bundle->discountSum);?>
            </p>
            <p>
                <span class="lrs-price-second uk-margin-right">Полная цена: <del><?php $bundle->renderPrice($bundle->totalSum);?></del></span>(вы экономите <?= $bundle->economySum;?> рублей)
            </p>
            <button type="button" class="uk-width-1-1 uk-button uk-button-success uk-button-large contactus-134">Записаться на сервис</button>
            <hr class="uk-article-divider">
            <!-- Краткое описание -->
	        <?php $bundle->renderTeaserDescription();?>
        </div>
    </div>
    <!-- Перечень работ -->
    <div class="uk-panel uk-panel-box uk-margin-large-top">
        <h2>Перечень работ</h2>
    </div>
    <div class="uk-overflow-container">
		<?php $bundle->renderWorksList();?>
    </div>
    <!-- Конец Перечень работ -->
    <!-- Перечень запчастей -->
    <div class="uk-panel uk-panel-box uk-margin-large-top">
        <h2>Перечень запчастей</h2>
    </div>
    <div class="uk-overflow-container">
		<?php $bundle->renderGoodsList();?>
    </div>
    <!-- Конец Перечень запчастей -->

    <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-top">
        <p class="uk-h2 uk-align-right">
            <button type="button" class="uk-button uk-button-success uk-button-large uk-margin-large-right contactus-134">
                Записаться на сервис
            </button>
			<?php $bundle->renderTotalSum();?>
        </p>
		<?php $bundle->renderExecutionTime();?>
    </div>

    <!--    <hr class="uk-article-divider">-->
    <?php $bundle->renderDescription();?>
	<?php $bundle->renderGallery();?>
	<?php $bundle->renderVideo();?>

    <hr class="uk-article-divider">
    <noindex>
        <!-- Флайерсы -->
        <div>{module 160}</div>
        <!-- Статистика -->
        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-large-top">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="uk-text-small">
                    <?php $bundle->renderHits();?>
                </div>
                <div>
                    <?php $bundle->renderRating();?>
                </div>
                <div>
                    <?= JLayoutHelper::render('b0.discuss', ['href' => 'https://vk.com/loganshopspb', 'src' => '/images/elements/icon-social/vk-icon.png']);?>
                </div>
                <div>
                    <?php $bundle->renderSocial();?>
                </div>
            </div>
        </div>
    </noindex>
</article>

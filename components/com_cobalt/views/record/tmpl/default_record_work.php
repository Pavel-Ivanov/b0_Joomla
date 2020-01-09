<?php
defined('_JEXEC') or die();
JImport('b0.Work.Work');
JImport('b0.fixtures');

//$user = $this->user;
/** @var JRegistry $paramsRecord */
$paramsRecord = $this->tmpl_params['record'];
$work = new Work($this->item, $this->user);
//b0dd($work);
$this->document->setTitle($work->metaTitle);
$this->document->setMetaData('description', $work->metaDescription);
JLayoutHelper::render('b0.openGraph', ['og' => $work->openGraph, 'doc' => $this->document]);
?>

<article class="uk-article" itemscope itemtype="https://schema.org/Product">
    <meta itemprop="name" content="<?= $work->title;?> за <?= $work->priceGeneral;?> рублей">
    <meta itemprop="description" content="<?= $work->metaDescription;?>">
    <meta itemprop="sku" content="<?= $work->serviceCode;?>">
    <meta itemprop="mpn" content="<?= $work->serviceCode;?>">
    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
        <meta itemprop="price" content="<?= ($work->isSpecial) ? $work->priceSpecial : $work->priceGeneral;?>"/>
        <meta itemprop="priceCurrency" content="RUB" />
        <meta itemprop="priceValidUntil" content="2019-12-31" />
        <meta itemprop="availability" content="InStock">
        <meta itemprop="acceptedPaymentMethod" content="Наличные, Кредитная карта"/>
        <meta itemprop="warranty" content="12 месяцев"/>
        <meta itemprop="url" content="<?= $work->url;?>"/>
    </div>
    <div itemprop="brand"  itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="<?= $work->siteName;?>" />
        <meta itemprop="address" content="Санкт-Петербург, ул. Седова, 13" />
        <meta itemprop="telephone" content="(812) 928-32-27, (812) 928-32-62, (800) 234-32-27" />
        <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
            <meta itemprop="url" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="image" content="https://logan-shop.spb.ru/images/logo/logan-shop-spb-logo.png" />
            <meta itemprop="height" content="80px" />
            <meta itemprop="width" content="170px" />
        </div>
    </div>

	<?php if($work->controls){
		echo JLayoutHelper::render('b0.controls', $work->controls);
	}?>

    <header>
		<?php $work->renderTitle();?>
    </header>
	<?php $work->renderSubTitle();?>
    <hr class="uk-article-divider">

    <div class="uk-grid" data-uk-grid-match>
        <div class="uk-width-1-2">
            <div>
                <?php if ($work->isSpecial) {?>
                    <p class="uk-text-danger ls-price-first">
                        Специальная цена: <?php $work->renderPrice($work->priceSpecial);?>
                    </p>
                    <p class="lrs-price-second">
                        Цена: <del><?php $work->renderPrice($work->priceGeneral);?></del>
                    </p>
<!--                    <p>-->
<!--                        Вы экономите: --><?php //$work->renderEconomy($work->priceGeneral, $work->priceSpecial);?>
<!--                    </p>-->
                <?php }
                else { ?>
                    <p class="ls-price-first uk-text-danger uk-text-center-small uk-margin-top">
                        Цена: <?php $work->renderPrice($work->priceGeneral);?>
                    </p>
                    <p class="lrs-price-second uk-text-center-small uk-margin-top">
                        Цена при первом визите: <?php $work->renderPrice($work->priceFirstVisit);?>
                    </p>
                    <p class="uk-text-small">
                        (В рамках <a href="<?= $paramsRecord->get('tmpl_core.actions_url');?>" target="_blank" title="Условия акции Приятное знакомство">
                            акции "Приятное знакомство"</a>)
                    </p>
                    <div class="accordion" id="prices-to-cards">
                        <div class="accordion-group" style="border: 0;">
                            <div class="uk-h4 accordion-heading">
                                <a class="accordion-toggle" style="padding-left: 0;" data-toggle="collapse"
                                   data-parent="#prices-to-cards" href="#collapse1"
                                   title="Посмотреть цены на работы с учетом скидок по дисконтной карте">
                                    <i class="uk-icon-gift uk-icon-medium uk-margin-right"></i>
                                    Посмотреть цены по дисконтной карте
                                </a>
                            </div>
                            <div id="collapse1" class="accordion-body collapse">
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-3 uk-panel-teaser">
                                        <img src="<?= $paramsRecord->get('tmpl_core.discount_card_icon');?>" alt="Дисконтная карта <?= $work->siteName;?>" />
                                    </div>
                                    <div class="uk-width-medium-2-3 uk-text-center-small">
                                        <p class="uk-h5 uk-margin-top">Стандартный уровень- <span class="uk-h4"><?php $work->renderPrice($work->priceSimple);?></span></p>
                                        <p class="uk-h5">Серебряный уровень- <span class="uk-h4"><?php $work->renderPrice($work->priceSilver);?></span></p>
                                        <p class="uk-h5">Золотой уровень- <span class="uk-h4"><?php $work->renderPrice($work->priceGold);?></span></p>
                                        <p>
                                            <a href="<?= $paramsRecord->get('tmpl_core.discounts_url');?>" target="_blank" title="Программа лояльности <?= $work->siteName;?>">
                                                <i class="uk-icon-exclamation-circle uk-margin-right"></i>
                                                Программа лояльности <?= $work->siteName;?>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="uk-width-1-2">
            <button type="button" class="uk-width-1-1 uk-button uk-button-success uk-button-large contactus-<?= $paramsRecord->get('tmpl_core.module_1');?>">
                Записаться на сервис
            </button>
            <!-- Время выполнения работы -->
	        <?php $work->renderEstimatedTime(); ?>
            <!-- Условия гарантии -->
            <p class="uk-h4">
                <a href="<?= $paramsRecord->get('tmpl_core.guarantee_url');?>" target="_blank" title="Посмотреть условия гарантии">
                    <i class="uk-icon-info-circle uk-margin-right"></i>Условия гарантии
                </a>
            </p>
        </div>
    </div>

	<?php $work->renderDescription();?>
	<?php $work->renderGallery();?>
	<?php $work->renderVideo();?>

    <hr class="uk-article-divider">
    <noindex>
        <div>{module <?= $paramsRecord->get('tmpl_core.module_2');?>}</div>
        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-large-top">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="uk-text-small">
	                <?php $work->renderHits();?>
                </div>
                <div>
	                <?php $work->renderRating();?>
                </div>
                <div>
	                <?= JLayoutHelper::render('b0.discuss', ['href' => $paramsRecord->get('tmpl_core.vk_url'), 'src' => $paramsRecord->get('tmpl_core.vk_icon')]);?>
                </div>
                <div>
	                <?php $work->renderSocial();?>
                </div>
            </div>
        </div>
    </noindex>

    <!-- Закладки -->
    <?= JLayoutHelper::render('b0.tabs', $work->tabs);?>
</article>

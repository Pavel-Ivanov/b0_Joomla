<?php
defined('_JEXEC') or die();
JImport('b0.Item.Item');
JImport('b0.ChipTuning.ChipTuning');
JImport('b0.fixtures');

//$item = $this->item;
//$params = $this->tmpl_params['record'];

$chipTuning = new ChipTuning($this->item, $this->user);
//b0dd($this->item);
//b0dd($chipTuning);
// Удаляем каноническую ссылку
foreach($this->document->_links as $lk => $dl) {
	if($dl['relation'] == 'canonical') {
		unset($this->document->_links[$lk]);
	}
}
//unset($this->document->_links);
unset($this->document->_generator);

//b0debug($this->document);

$this->document->setTitle($chipTuning->metaTitle);
$this->document->setMetaData('description', $chipTuning->metaDescription);
JLayoutHelper::render('b0.openGraph', ['og' => $chipTuning->openGraph, 'doc' => $this->document]);
?>

<style>
    .uk-block {
        padding-top: 25px;
        padding-bottom: 25px;
    }
</style>

<article class="uk-article" itemscope itemtype="https://schema.org/Product">

    <meta itemprop="name" content="<?= $chipTuning->title;?>">
    <meta itemprop="description" content="<?= $chipTuning->metaDescription;?>">
    <div itemprop="offers" itemscope itemtype="https://schema.org/Offer">
        <meta itemprop="price" content="<?= ($chipTuning->isSpecial) ? $chipTuning->priceSpecial : $chipTuning->priceGeneral;?>"/>
        <meta itemprop="priceCurrency" content="RUB" />
        <meta itemprop="acceptedPaymentMethod" content="Наличные, Кредитная карта"/>
        <meta itemprop="warranty" content="12 месяцев"/>
    </div>

	<?php if($chipTuning->controls):?>
        <nav class="uk-float-right">
            <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                <button class="uk-button-link">
                    <i class="uk-icon-cogs uk-icon-small"></i>
                </button>
                <div class="uk-dropdown uk-dropdown-small">
                    <ul class="uk-nav uk-nav-dropdown uk-panel uk-panel-box uk-panel-box-secondary">
						<?php $chipTuning->renderControls();?>
                    </ul>
                </div>
            </div>
        </nav>
	<?php endif;?>

    <div class="uk-grid">
        <div class="uk-width-medium-2-3">
            <div class="uk-block">
                <header itemprop="headline">
                    <h1 class="uk-text-center" style="font-size: 32px;">
						<?= $chipTuning->title;?>
                    </h1>
                </header>
            </div>
        </div>
        <div class="uk-width-medium-1-3">
            <div class="uk-block">
                <div class="uk-h2 uk-text-center">
                    <i class="uk-icon-phone uk-text-muted uk-margin-right"></i>
                    <a href="tel:+78129287737" class="uk-text-primary">+7 (812) 928-77-37</a>
                </div>
            </div>
        </div>
    </div>

    <div class="uk-grid">
        <div class="uk-width-medium-2-5">
            <a href="https://stoshilo.ru" title="StoShilo- первая специализированная передвижная лаборатория по чип-тюнингу автомобилей Ладa и Рено в СПб и ЛО" target="_blank">
                <img src="/images/elements/stoshilo/stoshilo.jpg" class="uk-text-center" alt="StoShilo -
                первая специализированная передвижная лаборатория по чип-тюнингу автомобилей Ладa и Рено в СПб и ЛО" width="400" height="253">
            </a>
        </div>
        <div class="uk-width-medium-3-5">
            <p class="uk-h4 uk-text-center">
                Прошивкой занимается наше отдельное подразделение
            </p>
            <p class="uk-h1 uk-text-center uk-text-danger">
                <a href="https://stoshilo.ru" title="StoShilo- первая специализированная передвижная лаборатория по чип-тюнингу автомобилей Ладa и Рено в СПб и ЛО" target="_blank">
                    <img src="/images/elements/stoshilo/logo-stoshilo.jpg" alt="" class="uk-margin-right" width="300" height="42">
                </a>
            </p>
            <p class="uk-h4 uk-text-center">
                первая специализированная передвижная лаборатория по чип-тюнингу автомобилей Ладa и Рено в СПб и ЛО.
            </p>
            <p class="uk-h2 uk-text-center uk-text-danger">
                Динамика и комфорт с гарантией!
            </p>
            <button type="button" class="uk-width-1-1 uk-button uk-button-success uk-button-large contactus-180 uk-margin-top">
                Записаться на чип-тюнинг в StoShilo
            </button>
        </div>
    </div>
    <hr class="uk-article-divider">


    <div class="uk-grid uk-grid-match uk-margin-large-top" data-uk-grid-match>
        <div class="uk-width-medium-2-5 uk-text-center"> <!-- Картинка -->
			<?//= $chipTuning->renderImage();?>
			<?= $chipTuning->teaserVideo['result'];?>
        </div>

        <div class="uk-width-medium-3-5">
            <p class="uk-h1 uk-text-center uk-text-danger">Откройте новые возможности своего автомобиля!</p>
			<?= $chipTuning->shortDescription;?>
<!--            <button type="button" class="uk-width-1-1 uk-button uk-button-success uk-button-large contactus-180 uk-margin-top">
                Записаться на чип-тюнинг
            </button>
-->        </div>
    </div>
<!--    <hr class="uk-article-divider">-->
	<?php $chipTuning->renderDescription();?>

    <ul class="uk-tab" data-uk-tab="{connect:'#my-id'}">
        <li class="uk-active"><a href="">Галерея</a></li>
<!--        <li><a href="">Отзывы клиентов</a></li>-->
<!--        <li><a href="">Видео</a></li>-->
    </ul>
    <ul id="my-id" class="uk-switcher uk-margin">
        <li><?php $chipTuning->renderGallery();?></li>
<!--        <li>--><?php //$chipTuning->renderReviews();?><!--</li>-->
<!--        <li>--><?php //$chipTuning->renderVideo();?><!--</li>-->
    </ul>
    
	<?php $chipTuning->renderGuarantee();?>

    <div class="uk-grid">
        <div class="uk-width-medium-1-2">
            <hr class="uk-article-divider">
            <div class="uk-block">
                <div class="uk-h2 uk-text-center" style="font-size: 28px;">
                    Записаться на чип-тюнинг
                </div>
            </div>
            <div class="uk-text-center">
                {module 181}
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <hr class="uk-article-divider">
            <div class="uk-block">
                <div class="uk-h2 uk-text-center" style="font-size: 28px;">
                    Обсудить или задать вопрос
                </div>
            </div>
            <div class="uk-text-center">
                {module 127}
            </div>
            <div class="uk-margin-top">
                <?= $chipTuning->links;?>
            </div>
        </div>
    </div>
    <!-- Статистика -->
    <noindex>
        <div class="uk-panel uk-panel-box uk-panel-box-secondary uk-margin-large-top">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-2-6 uk-text-small">
					<?php $chipTuning->renderHits();?>
                </div>
                <div class="uk-width-medium-2-6">
					<?php $chipTuning->renderRating();?>
                </div>
                <div class="uk-width-medium-2-6">
					<?php $chipTuning->renderSocial();?>
                </div>
            </div>
        </div>
    </noindex>
</article>

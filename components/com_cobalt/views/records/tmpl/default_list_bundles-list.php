<?php
defined('_JEXEC') or die();
//JImport('b0.Item.Item');
JImport('b0.Bundle.Bundle');
//JImport('b0.Bundle.BundleKeys');
//JImport('b0.fixtures');

$params = $this->tmpl_params['list'];
?>

<?php foreach ($this->items as $item):?>
    <?php
        $bundle = new Bundle($item);
    ?>
    <article class="uk-article uk-visible-hover">
        <!-- Панель управления -->
        <?php if ($bundle->controls) {
            echo '<div class="uk-hidden">';
	        echo JLayoutHelper::render('b0.controls', $bundle->controls);
	        echo '</div>';
        }?>
        <h2 class="uk-article-title uk-text-center-small">
            <a href="<?= $bundle->url;?>" target="_blank"><?= $bundle->title;?></a>
        </h2>

        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-2-10 uk-text-center-small">
	            <?php $bundle->renderImage();?>
            </div>
            <div class="uk-width-medium-5-10">
	            <?php $bundle->renderSubTitle();?>
            </div>
            <div class="uk-width-medium-3-10 uk-text-right uk-text-center-small">
                <div class="uk-panel uk-panel-box uk-vertical-align-middle uk-text-center-small">
					<?php
						echo '<p class="ls-price-second">';
						echo 'Цена: ';
						$bundle->renderPrice($bundle->discountSum);
						echo '</p>';
					?>
                </div>
            </div>
        </div>
    </article>
<?php endforeach;?>

<hr class="uk-article-divider">
<h2 class="uk-article-title uk-text-center-small">Дополнительные работы по электрике</h2>
<p>Мы выполняем любые виды работ по электрике и дооснащению  Рено Логан, Сандеро, Дастер, Каптюр, Доккер и Аркана:</p>
<div class="uk-grid" data-uk-grid-margin>
    <div class="uk-width-medium-1-2">
        <ul>
            <li>ремонт электрики;</li>
            <li>компьютерная диагностика;</li>
            <li>установка камеры заднего вида;</li>
            <li>установка парктроников;</li>
        </ul>

    </div>
    <div class="uk-width-medium-1-2">
        <ul>
            <li>установка видео регистратора (скрытое подключение);</li>
            <li>установка антирадара (скрытое подключение);</li>
            <li>заправка и диагностика кондиционера.</li>
        </ul>

    </div>
</div>
<p>На все выполненные работы дается гарантия.</p>
<p>В своей работе мы используем индивидуальный подход и всегда готовы исполнить Ваши пожелания.</p>
<ul class="uk-grid uk-text-center uk-margin-top" data-uk-grid-margin="">
    <li class="uk-width-medium-1-4">
        <img src="/images/bundles/other/electric-works-7.jpg" width="260" height="195"
             alt="Компьютерная диагностика Renault Logan, Sandero, Duster, Kaptur и Dokker" />
    </li>
	<li class="uk-width-medium-1-4">
        <img src="/images/bundles/other/electric-works-4.jpg" width="260" height="195"
             alt="Установка дополнительного оборудования Renault Logan, Sandero, Duster, Kaptur и Dokker" />
    </li>
    <li class="uk-width-medium-1-4">
        <img src="/images/bundles/other/electric-works-5.jpg" width="260" height="195"
             alt="Установка дополнительного оборудования Renault Logan, Sandero, Duster, Kaptur и Dokker" />
    </li>
	<li class="uk-width-medium-1-4">
        <img src="/images/bundles/other/electric-works-2.jpg" width="260" height="195"
             alt="Установка дополнительного оборудования Renault Logan, Sandero, Duster, Kaptur и Dokker" />
    </li>
</ul>


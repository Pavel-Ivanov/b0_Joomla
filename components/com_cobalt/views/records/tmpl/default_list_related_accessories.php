<?php
defined('_JEXEC') or die('Restricted access');
if(!$this->items) return;
JImport('b0.Accessory.AccessoryIds');
JImport('b0.pricehelper');

/** @var JRegistry $params */
$params = $this->tmpl_params['list'];
?>

<ul class="uk-grid uk-grid-width-medium-1-2 uk-grid-match" data-uk-grid-margin data-uk-grid-match="{target:'.uk-panel'}">
    <?php foreach ($this->items as $item) :
        $prices = ['general' => $item->fields_by_id[AccessoryIds::ID_PRICE_GENERAL]->value ?? 0,
                   'special' => $item->fields_by_id[AccessoryIds::ID_PRICE_SPECIAL]->value ?? 0,
                   'delivery' => $item->fields_by_id[AccessoryIds::ID_PRICE_DELIVERY]->value ?? 0,
                   'isSpecial' => $item->fields_by_id[AccessoryIds::ID_IS_SPECIAL]->value == 1 ? 1 : 0,
                   'isByOrder' => $item->fields_by_id[AccessoryIds::ID_IS_BY_ORDER]->value == 1 ? 1 : 0];
        ?>
        <li>
            <div class="uk-panel uk-panel-box">
                <div class="b0-title-related">
                    <a href="<?= JRoute::_($item->url);?>" title="<?= $item->title?>" target="_blank">
			            <?= $item->title; ?>
                    </a>
                </div>
	            <?php if (isset($fields[AccessoryIds::ID_SUBTITLE])) echo '<p class="uk-article-meta">'.$fields[AccessoryIds::ID_SUBTITLE]->result.'</p>';?>
                <hr class="uk-article-divider">
                <div class="uk-grid">
                    <div class="uk-width-1-3">
                        <?php if(isset($item->fields_by_id[AccessoryIds::ID_IMAGE])) {
                            echo ($item->fields_by_id[AccessoryIds::ID_IMAGE]->result);
                        }?>
                    </div>
                    <div class="uk-width-2-3">
                        <?php
                        if ($prices['isByOrder']) {
                            echo '<p class="b0-price-related">Ожидается поступление</p>';
                        }
                        elseif ($prices['isSpecial']) {
                            echo '<p class="b0-price-related uk-text-danger">Специальная цена: ' . render_price($prices['special']) . '</p>';
                            echo '<p class="b0-price-related">Цена: <del>' . render_price($prices['general']) . '</del>';
                        }
                        else {
                            echo '<p class="b0-price-related">Цена: ' . render_price($prices['general']). '</p>';
	                        echo '<p class="b0-price-related uk-text-danger">Цена при доставке: ' . render_price($prices['delivery']) . '</p>';
	                        if ($prices['general'] - $prices['delivery'] > 10) {
		                        echo '<p>Вы экономите ' . render_economy($prices['general'], $prices['delivery']).
			                        '&nbsp;<small>(Подробнее об <a href="'. $params->get('tmpl_core.link_delivery') .
			                        '" target="_blank" title="Условия доставки">условиях Доставки</a>)</small></p>';
	                        }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </li>
    <?php endforeach; ;?>
</ul>
<?php
defined('_JEXEC') or die('Restricted access');
if(!$this->items) return;

JImport('b0.Work.WorkIds');
JImport('b0.pricehelper');

/** @var JRegistry $params */
$params = $this->tmpl_params['list'];
?>
<ul class="uk-grid uk-grid-width-medium-1-2 uk-grid-match" data-uk-grid-margin data-uk-grid-match="{target:'.uk-panel'}">
	<?php foreach ($this->items as $item):?>
		<?php $fields = $item->fields_by_id;?>
        <li>
            <div class="uk-panel uk-panel-box">
                <div class="b0-title-related">
                    <a href="<?= JRoute::_($item->url);?>" title="<?= $item->title?>" target="_blank">
						<?= $item->title; ?>
                    </a>
                </div>
				<?php if (isset($fields[WorkIds::ID_SUBTITLE])) echo '<p class="uk-article-meta">'.$fields[WorkIds::ID_SUBTITLE]->result.'</p>';?>
                <hr class="uk-article-divider">
				<?php
				$isSpecial = ($fields[WorkIds::ID_IS_SPECIAL]->value == 1) ? true : false;
				$prices = ['general'=> $fields[WorkIds::ID_PRICE_GENERAL]->value,
				           'special'=> isset($fields[WorkIds::ID_PRICE_SPECIAL]) ? ($fields[WorkIds::ID_PRICE_SPECIAL]->value) : 0,
				           'firstVisit'=> isset($fields[WorkIds::ID_PRICE_FIRST_VISIT]) ? ($fields[WorkIds::ID_PRICE_FIRST_VISIT]->value) : 0
				];
				
				if ($isSpecial) {
					echo '<p class="b0-price b0-price-related uk-text-danger">Специальная цена: ' . render_price($prices['special']) . '</p>';
					echo '<p class="b0-price b0-price-related">Цена: <del>' . render_price($prices['general']) . '</del>';
					echo '<p>Вы экономите ' . render_economy($prices['general'], $prices['special']).'</p>';
				}
				else {
					echo '<p class="b0-price b0-price-related">Цена: ' . render_price($prices['general']) . '</p>';
					echo '<p class="b0-price b0-price-related uk-text-danger">Цена при первом визите: ' . render_price($prices['firstVisit']) . '</p>';
					if ($prices['general'] - $prices['firstVisit'] > 10) {
						echo '<p>Вы экономите ' . render_economy($prices['general'], $prices['firstVisit']).
                            '&nbsp;<small>(Скидка 20% по <a href="'. $params->get('tmpl_core.link_actions') .
                            '" target="_blank" title="Условия акции Приятное знакомство">акции "Приятное знакомство"</a>)</small></p>';
					}
				} ?>
            </div>
        </li>
	<?php endforeach;?>
</ul>

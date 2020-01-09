<?php
    defined('_JEXEC') or die('Restricted access');
if(!$this->items) return;
?>

<ul class="uk-grid uk-grid-width-1-1 uk-grid-width-medium-1-2" data-uk-grid-margin>
    <?php foreach ($this->items as $item) { ?>
        <li>
            <div class="uk-panel uk-panel-box">
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <p class="lrs-article-title-related">
                        <a href="<?php echo JRoute::_($item->url);?>"
                            title="<?php echo $item->title?>"
                           target="_blank">
                            <?php echo get_title_discount($item->title, 50);?>
                        </a>
                    </p>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-3">
                    <?php if(isset($item->fields_by_id[28])) echo ($item->fields_by_id[28]->result);?>
                </div>
                <div class="uk-width-2-3">
                    <hr class="lrs-hr">
                    <p class="lrs-price-related">
                        Специальная цена: <?php render_price_discount($item->fields_by_id[32]->value);?>
                    </p>
                    <p>
                        Цена: <del><?php render_price_discount($item->fields_by_id[30]->value);?></del>
                    </p>
                </div>
            </div>
            </div>
        </li>
    <?php }?>
</ul>

<?php
function get_title_discount($title, $cut_len) {
    return ((mb_strlen($title) > $cut_len) ? (mb_substr($title, 0, $cut_len-3) . '...') : $title);
}

function render_price_discount($price) {
    echo number_format($price, 0, '.', ' ').' RUB';
}
?>
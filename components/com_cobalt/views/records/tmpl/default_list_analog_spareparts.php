<?php
    defined('_JEXEC') or die('Restricted access');
if(!$this->items) return;
?>

<ul class="uk-grid uk-grid-width-1-1 uk-grid-width-medium-1-2" data-uk-grid-margin>
    <?php foreach ($this->items as $item):?>
        <li>
            <div class="uk-grid">
                <div class="uk-width-1-1">
                    <?php
                        $title = $item->title;
                        $len_title = mb_strlen($title);
                        $cut_len= 47;
                    ?>
                    <h5>
                        <a <?php echo $item->nofollow ? 'rel="nofollow"' : '';?>
                            href="<?php echo JRoute::_($item->url);?>"
                            title="<?php echo $title?>"
                            target="_blank">
                            <?php echo (($len_title > $cut_len) ? (mb_substr($title, 0, 45) . '...') : $title); ?>
                        </a>
                    </h5>
                </div>
            </div>
            <div class="uk-grid">
                <div class="uk-width-1-3">
                    <?php $key = $this->fields_keys_by_id[28];?>
                    <?php echo ($item->fields_by_key[$key]->result);?>
                </div>
                <div class="uk-width-2-3">
                    <?php
                    $price = $item->fields_by_id[30]->value;
                    $spec_price = $item->fields_by_id[32]->value;
                    $discount = $item->fields_by_id[57]->value[0];
                    $discount_price = round($price * ((100- $discount) / 100), -1);
                    ?>
                    <p class="uk-text-danger">
                        <?php if(!$item->featured) {
                            echo "Цена по карте: " . number_format($discount_price, 0, '.', ' ') . " руб.";
                        }
                        else {
                            echo "Специальная цена: ".number_format($spec_price, 0, '.', ' '). " руб.";
                        }?>
                    </p>
                    <p>
                        <?php if(!$item->featured) {
                            echo "Цена: " . number_format($price, 0, '.', ' ') . " руб.";
                        }
                        else {
                            echo "Цена: <del>".number_format($price, 0, '.', ' '). " руб.</del>";
                        }?>
                    </p>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
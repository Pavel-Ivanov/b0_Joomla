<?php
    defined('_JEXEC') or die('Restricted access');
if(!$this->items) return;
?>

<?php $summ = 0; ?>

<!--<h4>Перечень работ</h4>-->
<table class="uk-table">
    <thead>
        <tr>
            <th>Наименование</th>
            <th>Цена</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($this->items as $item):?>
            <tr  class="lrs-article-title-related">
                <td>
                    <a <?php echo $item->nofollow ? 'rel="nofollow"' : '';?> href="<?php echo JRoute::_($item->url);?>" target="_blank">
                        <?php echo $item->title?>
                    </a>
                </td>
                <td>
                    <?php $key = $this->fields_keys_by_id[5];?>
                    <?php echo ($item->fields_by_key[$key]->result);?>
                    <?php $summ = $summ + $item->fields_by_key[$key]->value; ?>
                </td>
            </tr>
        <?php endforeach;?>
        <tr  class="lrs-article-title-related">
            <td class="uk-text-right">Итого стоимость работ: </td>
            <td>
                <?php echo $summ." руб."; ?>
            </td>
        </tr>
    </tbody>
</table>
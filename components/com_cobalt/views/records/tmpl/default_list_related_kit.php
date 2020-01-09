<?php
    defined('_JEXEC') or die('Restricted access');
if(!$this->items) return;
?>

<div class="uk-grid uk-grid-width-1-1">
    <?php foreach ($this->items as $item) { ?>
            <a href="<?= JRoute::_($item->url);?>" target="_blank">
                <?= 'Смотреть '.$item->title?>
            </a>
<!--        <hr class="uk-article-divider">-->
    <?php } ?>
</div>
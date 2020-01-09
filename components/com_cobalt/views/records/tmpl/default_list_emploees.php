<?php
    defined('_JEXEC') or die('Restricted access');
if(!$this->items) return;
?>

<ul class="uk-grid uk-grid-width-medium-1-4" data-uk-grid-match>
    <?php foreach ($this->items as $item) {?>
        <li class="uk-text-center uk-margin-top">
            <?= $item->fields_by_id[108]->result;?>
            <h2 class="uk-article-title"><?= $item->title; ?></h2>
            <?= $item->rating;?>
            <p><?= $item->fields_by_id[109]->result;?></p>
            <?php if (isset($item->fields_by_id[110])) {
                echo '<p>'.$item->fields_by_id[110]->result.'</p>';
            }?>
            <p>С нами с <?= $item->fields_by_id[111]->result;?> года</p>
            <!-- Панель управления -->
            <?php if(($this->user->get('id')) AND ($item->controls)) { ?>
                <button class="uk-button-link">
                    <?= $item->controls[0];?>
                </button>
            <?php } ?>
            <hr class="uk-grid-divider">
        </li>
    <?php } ?>
</ul>
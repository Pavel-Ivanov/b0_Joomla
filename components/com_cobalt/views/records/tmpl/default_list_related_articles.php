<?php
defined('_JEXEC') or die('Restricted access');
JImport('b0.Wiki.WikiIds');
if(!$this->items) return;
?>

<ul class="uk-grid uk-grid-width-medium-1-2 uk-grid-match" data-uk-grid-margin data-uk-grid-match="{target:'.uk-panel'}">
    <?php foreach ($this->items as $item):?>
        <li>
            <div class="uk-panel uk-panel-box">
                <div class="uk-grid">
                    <div class="uk-width-1-1">
                        <p class="b0-title-related">
                            <a href="<?= JRoute::_($item->url);?>" title="<?= $item->title?>" target="_blank">
                                <?= $item->title; ?>
                            </a>
                        </p>
                    </div>
                </div>
                <hr class="uk-article-divider">
                <div class="uk-grid" data-uk-grid-margin>
                    <?php if (isset($item->fields_by_id[WikiIds::ID_IMAGE])) { ?>
                        <div class="uk-width-1-3">
	                        <?= $item->fields_by_id[WikiIds::ID_IMAGE]->result;?>
                        </div>
                        <div class="uk-width-2-3">
                            <?= $item->fields_by_id[WikiIds::ID_ANNOUNCEMENT]->result;?>
                        </div>
                    <?php }
                    else { ?>
                        <div class="uk-width-3-3">
                            <?= $item->fields_by_id[WikiIds::ID_ANNOUNCEMENT]->result;?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?php
defined('_JEXEC') or die();
$item = $this->item;
$params = $this->tmpl_params['record'];
// Удаляем каноническую ссылку
foreach($this->document->_links as $lk => $dl) {
	if($dl['relation'] == 'canonical') {
		unset($this->document->_links[$lk]);
	}
}
?>

<article class="uk-article">
        <div class="uk-button-group uk-float-right">
            <?php if($this->user->get('id')):?>
                <?php if($item->controls):?>
                    <div class="uk-float-right">
                        <div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">
                            <button class="uk-button-link">
                                <i class="uk-icon-cogs uk-icon-small"></i>
                            </button>
                            <div class="uk-dropdown uk-dropdown-small">
                                <ul class="uk-nav uk-nav-dropdown uk-panel uk-panel-box uk-panel-box-secondary">
                                    <?= list_controls($item->controls);?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            <?php endif;?>
        </div>
    <h1>
        <?= $item->title?>
    </h1>
    <hr class="uk-article-divider">
    <?= $item->fields_by_id[44]->result; ?>
</article>
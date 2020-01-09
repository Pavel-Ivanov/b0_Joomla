<?php
defined('_JEXEC') or die();
//JImport('b0.Kit.Kit');
JImport('b0.Kit.KitKeys');
JImport('b0.fixtures');

$item = $this->item;
//$params = $this->tmpl_params['record'];
//$kit = new Kit($this->item);
//b0dd($kit);
?>

<article class="uk-article">
    <?php if($item->controls) {
        echo JLayoutHelper::render('b0.controls', $item->controls);
    };?>

	<h1>
		<?= $item->title;?>
	</h1>
	<hr class="uk-article-didvider">

	<div>
		<?php if (isset($item->fields_by_key[KitKeys::KEY_SPAREPARTS_LIST])) {
			echo $item->fields_by_key[KitKeys::KEY_SPAREPARTS_LIST]->result;
		} ?>
	</div>
	<div>
		<?php if (isset($item->fields_by_key[KitKeys::KEY_ACCESSORIES_LIST])) {
			echo $item->fields_by_key[KitKeys::KEY_ACCESSORIES_LIST]->result;
		} ?>
	</div>
	<div>
		<?php if (isset($item->fields_by_key[KitKeys::KEY_WORKS_LIST])) {
			echo $item->fields_by_key[KitKeys::KEY_WORKS_LIST]->result;
		} ?>
	</div>
</article>

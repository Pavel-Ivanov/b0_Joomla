<?php
defined('_JEXEC') or die('Restricted access');
$params = $this->tmpl_params['cindex'];
$parent_id = ($params->get('tmpl_params.cat_type', 2) == 1 && $this->category->id) ? $this->category->id : 1;

$cats_model = $this->models['categories'];
$cats_model->section = $this->section;
$cats_model->parent_id = $parent_id;
$cats_model->order = $params->get('tmpl_params.cat_ordering', 'c.lft ASC');
$cats_model->levels = $params->get('tmpl_params.subcat_level');
$cats_model->all = 0;
$cats_model->nums = ($params->get('tmpl_params.cat_nums') || $params->get('tmpl_params.subcat_nums') || !$params->get('tmpl_params.cat_empty', 1));
$categories = $cats_model->getItems();

$cats = array();

foreach ($categories as $cat) {
	if ($params->get('tmpl_params.cat_empty', 1)
		|| ( !$params->get('tmpl_params.cat_empty', 1) && ($cat->num_current || $cat->num_all) ) )
	$cats[] = $cat;
}
if(!count($cats)) return;
?>

<ul class="uk-grid uk-text-center" data-uk-grid-margin>
    <?php foreach ($cats as $cat) { ?>
        <li class="uk-width-1-3">
            <a href="<?= JRoute::_($cat->link)?>">
                <img src="<?= $cat->image;?>" alt="<?= $cat->description; ?>" width="280" height="210">
                <h2 class="uk-article-title uk-margin-top"><?= $cat->title; ?></h2>
            </a>
        </li>
    <?php } ?>
</ul>

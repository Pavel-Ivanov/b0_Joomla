<?php
/**
 * Cobalt by MintJoomla
 * a component for Joomla! 1.7 - 2.5 CMS (http://www.joomla.org)
 * Author Website: http://www.mintjoomla.com/
 * @copyright Copyright (C) 2012 MintJoomla (http://www.mintjoomla.com). All rights reserved.
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */

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

foreach ($categories as $cat)
{
	if ($params->get('tmpl_params.cat_empty', 1)
		|| ( !$params->get('tmpl_params.cat_empty', 1) && ($cat->num_current || $cat->num_all) ) )
	$cats[] = $cat;
}
if(!count($cats)) return;

$cols = $params->get('tmpl_params.cat_cols', 3);
$rows = count($cats) / $params->get('tmpl_params.cat_cols',  3);
$rows = ceil($rows);
$ind = 0;
$span = array(1=>12,2=>6,3=>4,4=>3,6=>12);
$api = new CobaltApi();
?>

<?php if($this->tmpl_params['cindex']->get('tmpl_core.show_title', 1)):?>
	<h2><?php echo JText::_($this->tmpl_params['cindex']->get('tmpl_core.title_label', 'Category Index'))?></h2>
<?php endif;?>
<?php
//TODO если категория 1 уровня -> $cat->parent_id = '1' и можно показывать картинку
// нужно определить, когда показывать количество подкатегорий - $cat->childs_num
// или количество статей в категории $cat->records_num

?>

<ul class="uk-grid uk-text-center" data-uk-grid-margin>
    <?php foreach ($cats as $cat) { ?>
        <li class="uk-width-medium-1-4">
            <?php //$url = CImgHelper::getThumb(JPATH_ROOT.DIRECTORY_SEPARATOR.$cat->image, $params->get('tmpl_params.cat_img_width', 200), $params->get('tmpl_params.cat_img_height', 200), 'catindex');?>
	            <a href="<?= JRoute::_($cat->link)?>">
	<!--                <img src="--><?php //echo $url;?><!--" alt="--><?php //echo $cat->title; ?><!--">-->
		            <h2 class="uk-article-title">
			            <?= $cat->title; ?>
			            <?php if ($cat->records_num > 0) { ?>
			                <span class="badge badge-info"><?= $cat->records_num ?></span>
			            <?php }
			            else { ?>
			                <span class="badge badge-info"><?= $cat->childs_num ?></span>
			            <?php } ?>
		            </h2>
	            </a>
        </li>
    <?php } ?>
</ul>

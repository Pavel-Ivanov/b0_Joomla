<?php
/**
 * Cobalt by MintJoomla
 * a component for Joomla! 1.7 - 2.5 CMS (http://www.joomla.org)
 * Author Website: http://www.mintjoomla.com/
 * @copyright Copyright (C) 2012 MintJoomla (http://www.mintjoomla.com). All rights reserved.
 * @license GNU/GPL http://www.gnu.org/copyleft/gpl.html
 */
defined('_JEXEC') or die('Restricted access'); 

$k = $p1 = 0;
$params = $this->tmpl_params['list'];
$total_fields_keys = $this->total_fields_keys;
$fh = new FieldHelper($this->fields_keys_by_id, $this->total_fields_keys);
$exclude = $params->get('tmpl_params.field_id_exclude');
settype($exclude, 'array');
foreach ($exclude as &$value) {
	$value = $this->fields_keys_by_id[$value];
}
JHtml::_('dropdown.init');
?>
<style>
	.dl-horizontal dd {
		margin-bottom: 10px;
	}
	.left-dotted {
		border-left-style: solid;
		border-left-color: #dddddd;
		border-width: 1px;
		padding-left: 10px;
	}
</style>

<?php if($params->get('tmpl_core.show_title_index')):?>
	<h2><?php echo JText::_('CONTHISPAGE')?></h2>
	<ul>
		<?php foreach ($this->items AS $item):?>
			<li><a href="#record<?php echo $item->id?>"><?php echo $item->title?></a></li>
		<?php endforeach;?>
	</ul>
<?php endif;?>

<div>
	<?php foreach ($this->items AS $item):?>
		<div class="has-context<?php if($item->featured) echo ' success' ?>">
			<a name="record<?php echo $item->id;?>"></a>
            <div class="row-fluid">
                <div class="span12"> <!-- Заголовок -->
                    <?php if ($this->user->get('id')): ?>
                        <div class="pull-right controls">
                            <div class="btn-group" style="display: none;">
                                <?php echo HTMLFormatHelper::bookmark($item, $this->submission_types[$item->type_id], $params); ?>
                                <?php echo HTMLFormatHelper::follow($item, $this->section); ?>
                                <?php echo HTMLFormatHelper::repost($item, $this->section); ?>
                                <?php echo HTMLFormatHelper::compare($item, $this->submission_types[$item->type_id], $this->section); ?>
                                <?php if ($item->controls): ?>
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-mini">
                                        <img width="16" height="16" alt="<?php echo JText::_('COPTIONS') ?>"
                                             src="<?php echo JURI::root(TRUE) ?>/media/mint/icons/16/gear.png">
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?php echo list_controls($item->controls); ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if($params->get('tmpl_core.item_title')):?>
                        <?php if($this->submission_types[$item->type_id]->params->get('properties.item_title')):?>
                            <h2>
                                <?php if(in_array($params->get('tmpl_core.item_link'), $this->user->getAuthorisedViewLevels())):?>
                                    <a <?php echo $item->nofollow ? 'rel="nofollow"' : '';?> href="<?php echo JRoute::_($item->url);?>">
                                        <?php echo $item->title?>
                                    </a>
                                <?php else:?>
                                    <?php echo $item->title?>
                                <?php endif;?>
                                <?php echo CEventsHelper::showNum('record', $item->id);?>
                                <?php if($item->featured):?>
                                    <span class="label label-warning">Рекомендовано</span>
                                <?php endif;?>
                            </h2>
                        <?php endif;?>
                    <?php endif;?>
                </div>
                <div class="span12">
                    <div class="row-fluid"> <!-- Описание и цены -->
                        <div class="span8">  <!-- Описание -->
                            <?php $key=$this->fields_keys_by_id[54];?>
                            <?php if(isset($item->fields_by_key[$key])): ?>
                                <?php echo "<strong>".$item->fields_by_key[$key]->label . ": </strong>" . $item->fields_by_key[$key]->result; ?>
                                <br>
                            <?php endif;?>
                            <?php $key=$this->fields_keys_by_id[55];?>
                            <?php if(isset($item->fields_by_key[$key])): ?>
                                <?php echo "<strong>".$item->fields_by_key[$key]->label . ": </strong>" . $item->fields_by_key[$key]->result; ?>
                            <?php endif;?>
                            <?php $key=$this->fields_keys_by_id[59];?>
                            <?php if(isset($item->fields_by_key[$key])): ?>
                                <?php echo "<strong>".$item->fields_by_key[$key]->label . ": </strong>" . $item->fields_by_key[$key]->result; ?>
                            <?php endif;?>
                        </div>
                        <div class="span4 left-dotted">  <!-- Цены -->
                            <?php $key=$this->fields_keys_by_id[52];?>
                            <?php if(isset($item->fields_by_key[$key])): ?>
                                <?php echo "<strong>".$item->fields_by_key[$key]->label . ": </strong>" . $item->fields_by_key[$key]->result; ?>
                                <br>
                            <?php endif;?>
                            <?php $key=$this->fields_keys_by_id[53];?>
                            <?php if(isset($item->fields_by_key[$key])): ?>
                                <?php echo "<strong>".$item->fields_by_key[$key]->label . ": </strong>" . $item->fields_by_key[$key]->result; ?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
		</div>
		<hr>
	<?php endforeach;?>
</div>
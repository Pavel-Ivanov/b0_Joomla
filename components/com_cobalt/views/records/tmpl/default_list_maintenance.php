<?phpdefined('_JEXEC') or die('Restricted access'); $params = $this->tmpl_params['list'];?><?php foreach ($this->items as $item):?>	<article class="uk-article uk-visible-hover">		<!-- Панель управления -->		<?php if($this->user->get('id')):?>			<div class="uk-hidden uk-button-group uk-float-right" >				<?php if ($item->controls):?>					<div class="uk-float-right">						<div class="uk-button-dropdown" data-uk-dropdown="{mode:'click'}">							<button class="uk-button-link">								<i class="uk-icon-cogs uk-icon-small"></i>							</button>							<div class="uk-dropdown uk-dropdown-small">								<ul class="uk-nav uk-nav-dropdown uk-panel uk-panel-box uk-panel-box-secondary">									<?= list_controls($item->controls);?>								</ul>							</div>						</div>					</div>				<?php endif;?>			</div>		<?php endif;?>		<h2 class="uk-article-title">			<a href="<?= JRoute::_($item->url);?>" target="_blank">				<?= $item->title?>			</a>        </h2>        <?php            $subTitle = $item->fields_by_id[77]->result. ' ' . $item->fields_by_id[102]->result . ' км / ';            $subTitle .= $item->fields_by_id[84]->result . ' ';            $subTitle .= $item->fields_by_id[112]->result . ' / ';            $subTitle .= $item->fields_by_id[85]->result;            $subTitle .= ' / категории - ' . implode($item->categories);        ?>        <p class="uk-article-meta">            <?= $subTitle;?>        </p>	</article><?php endforeach;?>
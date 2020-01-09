<?php
defined('_JEXEC') or die();
JImport('b0.Partner.PartnerKeys');
JImport('b0.fixtures');

$listParams = $this->tmpl_params['list'];
?>

<?php foreach ($this->items as $item):?>
    <?php
        $fields = $item->fields_by_key;
    ?>
    <article class="uk-article uk-visible-hover">
        <!-- Панель управления -->
        <?php if ($item->controls) {
            echo '<div class="uk-hidden">';
	        echo JLayoutHelper::render('b0.controls', $item->controls);
	        echo '</div>';
        }?>
        <h2 class="uk-article-title uk-text-center-small">
            <?= $item->title;?>
        </h2>

        <div class="uk-grid" data-uk-grid-margin>
            <div class="uk-width-medium-1-5 uk-text-center-small uk-vertical-align">
			    <?php if(isset($fields[PartnerKeys::KEY_LOGO])) {
				    echo $fields[PartnerKeys::KEY_LOGO]->result;
			    }?>
            </div>
            <div class="uk-width-medium-4-5">
	            <?php if(isset($fields[PartnerKeys::KEY_BODY])) {
		            echo $fields[PartnerKeys::KEY_BODY]->result;
	            }?>
	            <?php if(isset($fields[PartnerKeys::KEY_SITE])) {
		            echo $fields[PartnerKeys::KEY_SITE]->result;
	            }?>
            </div>
        </div>
    </article>
<?php endforeach;?>

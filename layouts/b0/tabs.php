<?php
defined('JPATH_BASE') or die;

if (!$displayData) {
    return;
}
?>

<div class="uk-margin uk-width-medium-1-1">
	<!-- Заголовки закладок -->
	<ul class="uk-tab" data-uk-tab="{connect:'#tab-content'}">
		<?php
	    foreach ($displayData as $key => $tab ) {
		    //echo '<li' . (($tab['is_active'] == 1) ? ' class="uk-active"' : '') . '>';
		    echo '<li>';
		    echo '<a href="">' . $tab['title'] . ' ('.$tab['total'] .') '.'</a>';
		    echo '</li>';
	    }?>
	</ul>
	<!-- Контент закладок -->
	<ul class="uk-switcher uk-margin" id="tab-content">
		<?php
	    foreach ($displayData as $key => $tab ) {
		    echo '<li class="">' . $tab['result'] . '</li>';
	    }?>
	</ul>
</div>

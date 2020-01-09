<?php
defined('JPATH_BASE') or die;
if ($displayData) {
	//echo $displayData->get('result');
	echo '<p class="uk-article-lead">' . $displayData->get('result') . '</p>';
}

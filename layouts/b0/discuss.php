<?php
/** @var array $displayData
 * $displayData['href'] - Url ссылки на группу ВКонтакте
 *  $displayData['src'] - путь к иконке ВКонтакте
 */
defined('JPATH_BASE') or die;
if (!key_exists('href', $displayData)){
	return;
}
if (!key_exists('src', $displayData)){
	return;
}
?>
<p class="uk-h4">
    <a href="<?= $displayData['href'];?>" target="_blank" title="Обсудить или задать вопрос в нашей группе ВКонтакте">
	    <img src="<?= $displayData['src'];?>" width="24" height="24" class="uk-margin-right" alt="">
		Обсудить или задать вопрос
	</a>
</p>

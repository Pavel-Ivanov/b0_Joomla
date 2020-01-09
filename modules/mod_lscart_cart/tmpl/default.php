<?php
defined('_JEXEC') or die();
?>
<a href="<?= JRoute::_('cart'); ?>" rel="nofollow">
	<img src="/media/mod_lscart/images/icon-cart-turtle.png" width="60" height="60" alt=""/>
	<span class="badge" id="cart-count" style="font-size: 18px;"><?= $cart_count;?></span>
</a>

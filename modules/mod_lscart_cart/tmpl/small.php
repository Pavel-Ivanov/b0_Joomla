<?php
defined('_JEXEC') or die();
?>
<a href="<?= JRoute::_('cart'); ?>" rel="nofollow">
	<img src="/media/mod_lscart/images/icon-cart-turtle.png" width="50" height="50" alt="Корзина покупок"/>
	<span class="badge" id="cart-count-small" style="font-size: 18px;"><?= $cart_count;?></span>
</a>
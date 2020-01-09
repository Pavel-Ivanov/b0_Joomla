<?php


/**
 * @param integer $price
 *
 * @return string
 */
function render_price($price) {
	return number_format($price, 0, '.', ' ') . ' RUB';
}

/**
 * @param integer $price1
 * @param integer $price2
 *
 * @return string
 */
function render_economy ($price1, $price2) {
	$delta = $price1 - $price2;
	$percent = number_format(($delta / $price1) * 100, 0);
	return number_format($delta, 0, '.', ' ') . ' RUB ( ' . $percent . ' % )';
}

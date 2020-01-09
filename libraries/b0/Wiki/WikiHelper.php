<?php

/**
 * @param object|null $accessories
 * @param object|null $spareparts
 *
 * @return array
 *
 * @since version
 */
function wikiGetListGoods(object $accessories = null, object $spareparts = null)
{
	$listGoods = [];
	if (isset($spareparts)) {
		foreach ($spareparts->content['list'] as $goodsItem) {
			$listGoods[$goodsItem->id] = [
				'title' => $goodsItem->title,
				'url' => JRoute::_($goodsItem->url),
				'imageUrl' => $goodsItem->fields[SparepartIds::ID_IMAGE]['image'],
				'priceGeneral' => $goodsItem->fields[SparepartIds::ID_PRICE_GENERAL],
				'priceSpecial' => $goodsItem->fields[SparepartIds::ID_PRICE_SPECIAL],
				'isSpecial' => $goodsItem->fields[SparepartIds::ID_IS_SPECIAL],
				'isByOrder' => $goodsItem->fields[SparepartIds::ID_IS_BY_ORDER],
			];
		}
	}
	if (isset($accessories)) {
		foreach ($accessories->content['list'] as $goodsItem) {
			$listGoods[$goodsItem->id] = [
				'title' => $goodsItem->title,
				'url' => JRoute::_($goodsItem->url),
				'imageUrl' => $goodsItem->fields[AccessoryIds::ID_IMAGE]['image'],
				'priceGeneral' => $goodsItem->fields[AccessoryIds::ID_PRICE_GENERAL],
				'priceSpecial' => $goodsItem->fields[AccessoryIds::ID_PRICE_SPECIAL],
				'isSpecial' => $goodsItem->fields[AccessoryIds::ID_IS_SPECIAL],
				'isByOrder' => $goodsItem->fields[AccessoryIds::ID_IS_BY_ORDER],
			];
		}
	}
	return $listGoods;
}
<?php
defined('_JEXEC') or die;
JImport('b0.Item.Item');
JImport('b0.Core.Prices');
JImport('b0.Core.PricesKeys');
JImport('b0.Core.Represent');
JImport('b0.Core.RepresentKeys');
JImport('b0.Core.Applicability');
JImport('b0.Core.ApplicabilityKeys');
JImport('b0.Core.OpenGraph');


class ChipTuning extends Item implements PricesKeys, RepresentKeys, ApplicabilityKeys
{
	use Prices, Represent, Applicability, OpenGraph;
	//***
	private const KEY_PRODUCT_CODE = 'kad3298079b8c8638bae4d565425ec731';
	private const KEY_SUBTITLE = 'k988d70d9504e7cd4df51b5bd9cd6c766';
	private const KEY_SHORT_DESCRIPTION = 'kaa0cdfd391cf54d39f663daeddef5fae';
	private const KEY_SEARCH_SYNONYMS = 'kfbd541e87607957755493c8e6540b688';
	const KEY_TEASER_VIDEO = 'ka8994edd468479998d2f4e5c33a40513';
	const KEY_REVIEWS = 'kc718b10cbd14f52a8e6e5e4aaefa02ad';
	const KEY_GUARANTEE = 'k6f866ec9b9aa85aacfc66cb71a9b6aac';

	// Meta
	public $metaTitle;
	public $metaDescription;

	// Fields
	public $productCode;
	public $subTitle;
	public $shortDescription;
	public $teaserVideo;
	public $reviews;
	public $guarantee;

	public function __construct($item, $user = null, $microdata = null)
	{
		parent::__construct($item, $user);
		$fields = $item->fields_by_key;
		$this->productCode = $fields[ChipTuning::KEY_PRODUCT_CODE]->result ?? '';
		$this->subTitle = $fields[ChipTuning::KEY_SUBTITLE]->result ?? '';
		$this->shortDescription = $fields[ChipTuning::KEY_SHORT_DESCRIPTION]->result ?? '';
		//$this->teaserVideo = $fields[ChipTuning::KEY_TEASER_VIDEO]->result ?? null;
		if (!isset($fields[ChipTuning::KEY_TEASER_VIDEO])){
			$this->teaserVideo = null;
		}
		else {
			$this->teaserVideo = [
				'result' => $fields[ChipTuning::KEY_TEASER_VIDEO]->result,
				'url' => $fields[ChipTuning::KEY_TEASER_VIDEO]->value['link']
			];
		}

		$this->reviews = $fields[ChipTuning::KEY_REVIEWS]->result ?? '';
		if (!isset($fields[ChipTuning::KEY_REVIEWS])){
			$this->reviews = null;
		}
		else {
			$this->reviews = [
				'result' => $fields[ChipTuning::KEY_REVIEWS]->result,
				'url' => $fields[ChipTuning::KEY_REVIEWS]->value['fullpath']
			];
		}

		$this->guarantee = $fields[ChipTuning::KEY_GUARANTEE]->result ?? '';

		// Prices trait
		$this->setPriceGeneral($fields);
		$this->setIsSpecial($fields);
		$this->setPriceSpecial($fields);
		// Represent trait
		$this->setRepresent($fields);
		// Applicability trait
		$this->setApplicability($fields);

		$this->title = $this->setTitle();
		$this->metaTitle = $this->setMetaTitle();
		$this->metaDescription = $this->setMetaDescription($item);
		$this->metaKey = '';

		$this->setOpenGraph($this);
	}

	private function setTitle(): string
	{
		return $this->title;
	}

	private function setMetaTitle(): string
	{
		return 'Прошивка || Чип-тюнинг Рено Логан, Сандеро, Дастер и Каптюр в Логан-Шоп СПб';
	}

	private function setMetaDescription($item): string
	{
		return $item->meta_descr;
	}

	public function renderShortDescription()
	{
		if (!$this->shortDescription) {
			return;
		}
		echo $this->shortDescription;
	}

	public function renderTeaserVideo()
	{
		if (!$this->teaserVideo) {
			return;
		}
		echo '<div class="uk-margin-top uk-margin-large-bottom">';
		echo '<hr class="uk-article-divider">';
		echo $this->teaserVideo['result'];
		echo '</div>';
	}

	public function renderReviews()
	{
		if (!$this->reviews) {
			return;
		}
		echo '<div class="uk-margin-top uk-margin-large-bottom">';
		echo '<hr class="uk-article-divider">';
		echo $this->reviews['result'];
		echo '</div>';
	}

	public function renderGuarantee()
	{
		if (!$this->guarantee) {
			return;
		}
		echo $this->guarantee;
	}

}
<?php
defined('_JEXEC') or die;
JImport('b0.Item.Item');
JImport('b0.Core.Prices');
JImport('b0.Core.PricesKeys');
JImport('b0.Core.Represent');
JImport('b0.Core.RepresentKeys');
JImport('b0.Core.Applicability');
JImport('b0.Core.ApplicabilityKeys');
JImport('b0.Work.WorkKeys');

class Work extends Item implements PricesKeys, RepresentKeys, ApplicabilityKeys
{
	use Prices, Represent, Applicability;
	//***
	private const TITLE_RELATED_SPAREPARTS = 'Рекомендуемые запчасти';
	private const TITLE_RELATED_ACCESSORIES = 'Рекомендуемые аксессуары';
	private const TITLE_RELATED_WORKS = 'Сопутствующие работы';
	// Meta
	public $metaTitle;
	public $metaDescription;
	public $openGraph;
	public $microdata;
	// Fields
	public $serviceCode;
	public $subTitle;
	public $estimatedTime;
	// Tabs
	private $tabsTemplate = [
		WorkKeys::KEY_SPAREPARTS => [
			'title' => Work::TITLE_RELATED_SPAREPARTS,
		],
		WorkKeys::KEY_ACCESSORIES => [
			'title' => Work::TITLE_RELATED_ACCESSORIES,
		],
		WorkKeys::KEY_WORKS => [
			'title' => Work::TITLE_RELATED_WORKS,
		]
	];
	public $tabs = [];

	public function __construct($item, $user = null, $microdata = null)
	{
		parent::__construct($item, $user);
		$fields = $item->fields_by_key;
		$this->serviceCode = $fields[WorkKeys::KEY_SERVICE_CODE]->result ?? '';
		$this->subTitle = $fields[WorkKeys::KEY_SUBTITLE]->result ?? '';
		$this->estimatedTime = $fields[WorkKeys::KEY_ESTIMATED_TIME]->result ?? '';
		// Set Prices
		$this->setPriceGeneral($fields);
		$this->setPriceSimple($fields);
		$this->setPriceSilver($fields);
		$this->setPriceGold($fields);
		$this->setPriceSpecial($fields);
		$this->setPriceFirstVisit($fields);
		$this->setIsSpecial($fields);
		// Set Represent
		$this->setRepresent($fields);
		// Set Applicability
		$this->setApplicability($fields);

		$this->metaTitle = $this->setMetaTitle();
		$this->metaDescription = $this->setMetaDescription($item);
		$this->metaKey = '';
		// Set Open Graph
		$this->openGraph = [
			'og:type' => 'article',
			'og:title' => $this->title,
			'og:url' => $this->url,
			'og:description' => $this->metaDescription,
			'og:site_name' => $this->siteName,
			'og:locale' => 'ru_RU',
		];
		// Set video
		if ($this->video['result']) {
			$this->openGraph += [
				'og:video' => $this->video['url'],
				'og:video:secure_url' => $this->video['url'],
				'og:video:type' => 'video/mp4',
				'og:video:width' => '640',
				'og:video:height' => '480',
			];
		}
		// Set Tabs
		foreach ($this->tabsTemplate as $key => $tab) {
			if (!isset($fields[$key])) {
				continue;
			}
			$this->tabs[$key] = [
				'title' => $tab['title'],
				'total' => $fields[$key]->content['total'],
				'result' => $fields[$key]->content['html']
			];
		}
	}

	private function setMetaTitle(): string
	{
		return $this->title . ' за ' . $this->priceGeneral . ' рублей в ' . $this->siteName;
	}

	private function setMetaDescription($item): string
	{
		//return $this->title . ' за ' . $this->priceGeneral . ' рублей в ' . $this->siteName;
		return $item->meta_descr . ' за ' . $this->priceGeneral . ' рублей в ' . $this->siteName;
	}

	public function renderSubTitle()
	{
		if (!$this->subTitle) {
			return;
		}
		echo '<p class="uk-article-lead">' . $this->subTitle . '</p>';
	}

	public function renderEstimatedTime()
	{
		if (!$this->estimatedTime) {
			return;
		}
		echo '<p>';
		echo '<strong>Ориентировочное время выполнения работы: </strong>'.$this->estimatedTime;
		echo '</p>';
	}

}
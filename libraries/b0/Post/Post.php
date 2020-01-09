<?php
defined('_JEXEC') or die;

JImport('b0.Item.Item');
JImport('b0.Post.PostKeys');
JImport('b0.Core.Represent');
JImport('b0.Core.OpenGraph');
JImport('b0.Core.Meta');

class Post extends Item implements RepresentKeys
{
	use Represent, OpenGraph, Meta;

	// Fields
	public $announcement;
	public $body;

	public function __construct($item, $user)
	{
		parent::__construct($item, $user);
		$fields = $item->fields_by_key;
		$this->metaTitle = $item->title;
		$this->metaDescription = $item->title;
		$this->metaKey = '';

		$this->announcement = $fields[PostKeys::KEY_ANNOUNCEMENT]->result ?? '';
		$this->body = $fields[PostKeys::KEY_BODY]->result ?? '';
		$this->setRepresent($fields);
		$this->setOpenGraph($this);
	}

	public function renderBody() {
		if (!$this->body) {
			return;
		}
		echo $this->body;
	}
}


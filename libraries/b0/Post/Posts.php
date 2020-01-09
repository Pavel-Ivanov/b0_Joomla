<?php
defined('_JEXEC') or die();

JImport('b0.Post.PostKeys');

class Posts
{
	public $items;
	
	/**
	 * Posts constructor.
	 *
	 * @param      $items
	 * @param JRegistry $params
	 */
	public function __construct($items, $params)
	{
		foreach ($items as $item) {
			$post = new stdClass();
			$post->id = $item->id;
			$post->url = $item->url;
			$post->title = $item->title;
			$post->controls = $item->controls;
			$post->image = $item->fields_by_key[PostKeys::KEY_IMAGE]->result ?? '';
			
			//Properties
			$post->announcement = $item->fields_by_key[PostKeys::KEY_ANNOUNCEMENT]->result ?? '';
			$post->ctime = $item->ctime->format($params->get('tmpl_core.item_time_format'));
			
			$this->items[$item->id] = $post;
		}
	}
}

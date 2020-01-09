<?php
defined('_JEXEC') or die;

trait OpenGraph
{
	public $openGraph = [];
	
	private function setOpenGraph($article)
	{
		$this->openGraph = [
			'og:type' => 'article',
			'og:title' => $article->title,
			'og:url' => $article->url,
			'og:description' => $article->metaDescription,
			'og:site_name' => $article->siteName,
			'og:locale' => 'ru_RU',
		
		];
		
		$images = [];
		if ($article->image['result']) {
			$images[] = [
				'og:image' => $article->image['url'],
				'og:image:secure_url' => $article->image['url'],
				'og:image:type' => 'image/jpeg',
				'og:image:width' => '400',
				'og:image:height' => '300',
			];
		}
		if ($article->gallery['result']) {
			$baseUrl = $article->gallery['baseUrl'];
			foreach ($article->gallery['url'] as $url) {
				$images[] = [
					'og:image' => $baseUrl . $url,
					'og:image:secure_url' => $baseUrl . $url,
					'og:image:type' => 'jpg',
					'og:image:width' => '800',
					'og:image:height' => '600'
				];
			}
		}
		$this->openGraph += [
			'og:image' => $images
		];
		
		if ($article->video['result']) {
			$videos = [];
			foreach ($article->video['url'] as $url) {
				$videos[] = [
					'og:video' => $url,
					'og:video:secure_url' => $url,
					'og:video:type' => 'video/mp4',
					'og:video:width' => '640',
					'og:video:height' => '480'
				];
			}
			$this->openGraph += [
				'og:video' => $videos
			];
		}
	}
}
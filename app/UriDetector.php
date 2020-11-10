<?php

namespace App;

class UriDetector
{
	const TYPE_POST = 'post';
	const TYPE_PAGE = 'page';

	public function detect(string $uri): array
	{
		$type = self::TYPE_POST;
		$name = '';

		if (strpos($uri, '/posts/') === 0) {
			$type = self::TYPE_POST;
			preg_match('/^\/posts\/(.+)\.html$/', $uri, $matches);
			$slug = $matches[1];
			$name = self::findPostBySlug($slug);
		}

		return $result;
	}

	protected function findPostBySlug(string $slug)
	{

	}
}

<?php

namespace App;

use Illuminate\Filesystem\Filesystem;

class UriDetector
{
	const TYPE_POST = 'post';
	const TYPE_PAGE = 'page';

	protected string $currentPath;

	protected Filesystem $filesystem;

    public function __construct()
    {
        $this->currentPath = getcwd();
        $this->filesystem = new Filesystem();
	}

	public function detect(string $uri): array
	{
		$type = self::TYPE_POST;
		$name = '';

		if (strpos($uri, '/posts/') === 0) {
			$type = self::TYPE_POST;
			preg_match('/^\/posts\/(.+)\.html$/', $uri, $matches);
			$slug = $matches[1];
			$name = $this->findPostBySlug($slug);
		}

		return [
		    'type' => $type,
            'name' => $name
        ];
	}

	protected function findPostBySlug(string $slug)
	{
	    $files = $this->filesystem->allFiles('posts');

	    dd($files[0]->getPathname());
        return $slug;
	}
}

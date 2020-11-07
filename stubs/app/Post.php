<?php

/**
 * Class Post
 *
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $created_at
 * @property string $layout
 */
class Post
{
    private array $attributes;

    /**
     * Post constructor.
     * From this point, you can customize what you want for the post data,
     * such as default layout, transform attributes...
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }
    public function link()
    {
        return "/posts/{$this->slug}.html";
    }

    public function attributes(): array
    {
        return $this->attributes;
    }

    public function __get(string $attribute)
    {
        return $this->attributes[$attribute] ?? null;
    }
}

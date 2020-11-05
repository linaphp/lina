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

    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
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

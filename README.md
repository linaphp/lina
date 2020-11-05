# pekyll

[![tests](https://github.com/bangnokia/pekyll/workflows/Run%20test/badge.svg)](https://github.com/bangnokia/pekyll/actions)

static blog generator crafted by php with 😘. inspire from Jekyll.
pekyll has power of `blade` template engine from `laravel`.
and it's simple.

## getting started

- install php 7.4
- install [composer](https://getcomposer.org/download/)
- Install `pekyll` with composer command: `composer global require bangnokia/pekyll`
- create new blog: `pekyll new yourblog`

## structure

- `app/Post.php`: the `Post` class when building from your markdown file. here you can customize what you want.
- `posts`: the directory for store your blog content `.md` files.
- `images`: put your images here.
- `resources/views`: include blade template files for building html files.
- `resources/cache`: storing compiled template files.
- `resources/css`: put your css files here.
- `resources/js`: put your javascript files here.
- `public`: the built html files will be stored here, serve as the front page for your blog. **don't put any thing here**.
- `public/images`: symbolic link of `images`.
- `public/css`: symbolic link of `resources/css`.
- `public/js`: symbolic link of `resources/js`.

## markdown file syntax for post

- your markdown file must follow syntax: `yyyy-mm-dd-this-is-slug.md`. example `2020-11-01-hello-world.md`, then you will have `$post->created_at = '2020-11-01''` and `$post->slug = 'hellow-world'`
- file content
```
// the first is yaml likes format
---
layout: post // refence to resources/views/post.blade.php, use for building html
title: This is post title // $post->title = 'This is post title'
foo: bar // $post->foo = 'bar'
tags[]: dog, cat, pekyll // $post->tags = ['dog', 'cat', 'pekyll']
---
// markdown content bellow will be parsed as html content then assigns to $post->content
*hello world*

```

## commands

- `pekyll new`: create new fresh blog
- `pekyll build`: build your blog to html files in public folder
- `pekyll serve`: run a development server 

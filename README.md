# pekyll

[![tests](https://github.com/bangnokia/pekyll/workflows/Run%20test/badge.svg)](https://github.com/bangnokia/pekyll/actions)


static blog generator crafted by php with 😘. inspires from [Jekyll](https://jekyllrb.com).

pekyll has power of [`blade`](https://laravel.com/docs/8.x/blade) template engine from `laravel`.

and it's simple.


## getting started

- install php 7.4
- install [composer](https://getcomposer.org/download/)
- Install `pekyll` with composer command: `composer global require bangnokia/pekyll`
- create new blog: `pekyll new yourblog`

## structure

| folder/file       | why existed       |
|-------------------|-------------------|
| `app/Post.php`    | the `Post` class when building from your markdown file. here you can customize what you want |
| `posts`           | the directory for store your blog content `.md` files |
| `images`          | put your images here |
| `resources/views` | include blade template files for building html files |
| `resources/cache` | storing compiled template files |
| `resources/css`   | put your css files here |
| `resources/js`    | put your javascript files here |
| `public`          | the built html files will be stored here |
| `public/images`   | symbolic link of `images` |
| `public/css`      | symbolic link of `resources/css` |
| `public/js`       | symbolic link of `resources/js` |

## markdown file syntax for post

your markdown file must follow syntax: `yyyy-mm-dd-this-is-slug.md`. example `2020-11-01-hello-world.md` then will be parsed become `$post->created_at = '2020-11-01'` and `$post->slug = 'hellow-world'`

file content

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

## appendix

php is alive
```

## commands

| command          | action           |
|------------------|------------------|
| `pekyll new`     | create new fresh blog |
| `pekyll build`   | build your blog to html files |
| `pekyll serve`   | run a development server, replace asset's folders in public by symbolic link |

## routes

There are only 2 types of route:
- `page`: `xxx.html` rendered from `resources/views/pages`
- `post`: `posts/xxx.html` rendered from `posts/`

## how it works

`pekyll` parse content of file in the `posts` directory to make `post` html file. After that, it starts build `pages`. There for you can access all the posts in the pages view via `$posts` variable, it's a [`Collection`](https://laravel.com/docs/8.x/collections#introduction) of `Post` class. You are free to filters go get what you want here.

## deployment

### github pages

By default, `pekyll` support for auto deploy on gh-pages using github action. If you want do some customize, please take a look at `.github/workflows/deploy.yml`.
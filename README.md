# Lina PHP - lightweight and blazing fast static blog generator

**Lina** is an opinionated flat-file CMS for who want a simple and fast blog. The template using Blade template engine, so you can use all Blade features.

To help you get started, we have created a few example posts. You can find them in the `content/posts` directory.

## Requirements
- PHP 8.3

## Getting started
```bash
lina new my-blog
```

### Create a blog
```bash
composer global require bangnokia/lina
```

### Folder structure
Lina is best suited for a simple blog. The folder structure is as follows:
```
content/
    posts/
        2020-11-01-hello.md
    index.md
resources/
    views/
public/
    images/
    style.css
```

There are some functions that you can use to get content from your site.

### Get all content in a directory

```php
foreach (lina()->index('post') as $post) {
    echo $post->title;
}
```

### Template engine
Lina uses Blade template engine. So basically, you can use all Blade features.

### Get a single content

```php
$post = lina()->get('posts/2020-11-01-hello.md');
```



## TODO

- [x] Add `lina serve` command for development
- [x] Add code highlighter support
- [ ] support live reloading
- [x] Cloudflare pages support

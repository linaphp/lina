# Lina PHP - lightweight and blazing fast static blog generator

**Lina** is an opinionated flat-file CMS for who want a simple and fast blog. The template using Blade template engine, so you can use all Blade features.

## Features
- **Blazing fast**: Lina is a lightweight and superfast static blog generator.
- Written in PHP: so if you hate Javascript, Lina is for you.
- Blade template engine: you can use all Blade features.'
- Minimalistic: Lina is a static blog generator. It's not a full-fledged CMS.
- Deploy everywhere! You know, just html files 🤣

## Requirements
- PHP 8.3

## Getting started
```bash
composer global require bangnokia/lina
```

### Create a blog
To create a skeleton blog, as a starting point, you can use the `new` command.
```bash
lina new my-blog
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

### Get a single content

```php
$post = lina()->get('posts/2020-11-01-hello.md');
```



## TODO

- [x] Add `lina serve` command for development
- [x] Add code highlighter support
- [ ] support live reloading
- [x] Cloudflare pages support

# Lina PHP - lightweight and blazing fast static blog generator

**Lina** is an opinionated flat-file CMS for who want a simple and fast blog. Lina uses Blade template engine, so you can use all Blade features.

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

In case you want to migrate from another blog platform, you can check the base structure of Lina
```
content/
    posts/
        2020-11-01-hello.md
    index.md
resources/
    views/
        index.blade.php
        post.blade.php
public/ 
    images/
    style.css
```


- `content` directory is where you store your markdown content file.
- `resources/views` directory is where you store your blade template.
- `public` directory is where you store your assets like images, css, ... This folder is also where all the generated files are stored. So please remember to add your custom files to `.gitignore` if you want to store them in `git`

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

## Deployments
Lina can be deployed to any static hosting provider. Here are some examples: Github pages, Netlify, Vercel, Cloudflare pages, ...
We also support Cloudflare pages and Github pages if you start a new blog with `lina new my-blog`. Otherwise, you can check out the scripts in the `skeleton` directory.

## TODO

- [x] Add `lina serve` command for development
- [x] Add code highlighter support
- [ ] Support live reloading
- [x] Cloudflare pages support

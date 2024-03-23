---
title: Welcome to Lina
layout: home
---

**Lina** is an opinionated flat-file CMS for who want a simple and fast blog. The template using Blade template engine, so you can use all Blade features.

## Get all content in a directory

```php
foreach (cf()->index('post') as $post) {
    echo $post->title;
}
```

```html
    <h1>Hello world</h1>
```

```
normal no html <h1>welcome to vietnam</h1>
```

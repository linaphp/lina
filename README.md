# pekyll

[![tests](https://github.com/bangnokia/pekyll/workflows/Run%20test/badge.svg)](https://github.com/bangnokia/pekyll/actions)

static blog generator crafted by php with 😘. inspire from Jekyll.
pekyll has power of `blade` template engine from `laravel`.
and it's simple.

## getting started

- install php 7.4
- install [composer](https://getcomposer.org/download/)
- Install `pekyll` with composer command: `composer require bangnokia/pekyll`
- Create new blog: `pekyll new yourblog`

## structure

- `app\Post.php`: he `Post` class when building from your markdown file. here you can customize what you want.
- `posts`: the directory for store your blog content `.md` file.
- `resources\views`: include blade template files for building html file.
- `resources\cache`: storing compiled template files.
- `public`: the built html files will be stored here, serve as the front page for your blog. **don't put any thing here**.


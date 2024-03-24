<?php

use BangNokia\Lina\Parser;

beforeEach(function () {
    $this->parser = app()->make(Parser::class);
});

it('can parse meta and markdown text from raw file', function () {
    $text = <<<EOF
---
layout: post
title: hello
---

# hello
welcome to the world
EOF;

    ['yaml' => $yaml, 'markdown' => $markdown] = $this->parser->classify($text);

    $this->assertEquals($yaml, <<<EOF
layout: post
title: hello
EOF
    );

    $this->assertEquals($markdown, <<<EOF
# hello
welcome to the world
EOF
    );
});

it('can parse meta to array', function () {
    $meta = $this->parser->parseFrontMatter(<<<EOF
title: hello world
layout: post
tags:
  - foo
  - bar
  - foo bar
blank:
EOF
    );

    expect($meta)->tobe([
        'title'  => 'hello world',
        'layout' => 'post',
        'tags'   => ['foo', 'bar', 'foo bar'],
        'blank' => null
    ]);
});

test('parse content to array data', function () {
    $result = $this->parser->parse(<<<EOF
---
title: foo
---
# hello
EOF
);

    $this->assertEquals('foo', $result['front_matter']['title']);
    $this->assertEquals('<h1 id="hello" name="hello">hello</h1>', $result['content']);
})->skip();

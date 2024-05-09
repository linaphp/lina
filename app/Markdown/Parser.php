<?php

namespace LinaPhp\Lina\Markdown;

use Tempest\Highlight\Highlighter;

class Parser extends \Parsedown
{
    protected Highlighter $highlighter;

    public function __construct()
    {
        $this->highlighter = new Highlighter();
    }

    protected function blockFencedCodeComplete($Block)
    {
        $block = parent::blockFencedCodeComplete($Block);

        if (!isset($block['element']['text']['text'])) {
            return $block;
        }

        $code = $block['element']['text']['text'];
        $language = explode('-', $block['element']['text']['attributes']['class'] ?? '')[1] ?? 'html';

        $highlighted = $this->highlighter->parse($code, $language);

        $block['element']['text']['rawHtml'] = $highlighted;
        unset($block['element']['text']['text']);

        return $block;
    }
}

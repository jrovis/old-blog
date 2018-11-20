<?php

namespace App\Innote\Traits;

trait Markdown
{
    public function convertMarkdownToHtml($markdown)
    {
        $convertedHmtl = app('Parsedown')->setBreaksEnabled(true)->text($markdown);
        $convertedHmtl = str_replace("<pre><code>", '<pre><code class=" language-php">', $convertedHmtl);

        return $convertedHmtl;
    }
}

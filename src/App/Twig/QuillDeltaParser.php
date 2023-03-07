<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use nadar\quill\Lexer;
use Twig\Markup;
use Twig\TwigFilter;

class QuillDeltaParser extends AbstractExtension
{
    private Environment $twigEnv;

    public function __construct(Environment $twigEnv)
    {
        $this->twigEnv = $twigEnv;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('quill', [$this, 'parseQuillDelta'])
        ];
    }

    public function parseQuillDelta(string $quillDelta, bool $stripTags = false): Markup
    {
        $lexer = new Lexer($quillDelta);
        $data = $lexer->render();

        if ($stripTags) {
            $data = \strip_tags($data);
        }

        $data = \str_replace(['<p>', '</p>'], '', $data);

        return new Markup($data, $this->twigEnv->getCharset());
    }
}

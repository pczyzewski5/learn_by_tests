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

    public function parseQuillDelta(string $quillDelta): Markup
    {
        $lexer = new Lexer($quillDelta);

        return new Markup($lexer->render(), $this->twigEnv->getCharset());
    }
}

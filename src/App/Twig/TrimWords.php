<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use nadar\quill\Lexer;
use Twig\Markup;
use Twig\TwigFilter;

class TrimWords extends AbstractExtension
{
    private Environment $twigEnv;

    public function __construct(Environment $twigEnv)
    {
        $this->twigEnv = $twigEnv;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('trimWords', [$this, 'trimWords'])
        ];
    }

    public function trimWords(string $text, ?int $maxLength = 65): string
    {
        $result = '';

        foreach (\explode(' ', $text) as $word) {
            $length = \strlen($result) + \strlen($word);

            if ($length > ($maxLength - 3)) {
                $result .= '...';
                break;
            }

            if (\strlen($result) > 0) {
                $result .= ' ';
            }

            $result .= $word;
        }

        return $result;
    }
}

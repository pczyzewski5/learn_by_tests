<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class ParseSrcPdf
{
    private string $srcPdfFileLocation;

    public function __construct(string $srcPdfFileLocation)
    {
        $this->srcPdfFileLocation = $srcPdfFileLocation;
    }

    public function getSrcPdfFileLocation(): string
    {
        return $this->srcPdfFileLocation;
    }
}

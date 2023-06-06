<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use App\Controller\SrcPdfParser;

class ParseSrcPdfHandler
{
    public function handle(ParseSrcPdf $command): void
    {
        $questionWithAnswers = (new SrcPdfParser())->parse($command->getSrcPdfFileLocation());

        var_dump($questionWithAnswers);exit;
    }
}

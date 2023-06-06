<?php

declare(strict_types=1);

namespace App\Controller;

use Smalot\PdfParser\Parser;

class SrcPdfParser
{
    public function parse(string $file): array
    {
        $text = $this->getTextFromFile($file);
        $text = $this->removeNewLines($text);
        $text = $this->removeTabs($text);
        $text = $this->removeDoubleSpaces($text);
        $text = $this->cutStringToFirstQuestion($text);

        $result = [];
        $questionNumber = 2;

        while(\strlen($text) > 0) {
            $question = \substr($text, 0, \strpos($text, 'A. '));
            $text = \substr($text, \strlen($question));

            $answerA = \substr($text, 0, \strpos($text, 'B. '));
            $text = \substr($text, \strlen($answerA));

            $answerB = \substr($text, 0, \strpos($text, 'C. '));
            $text = \substr($text, \strlen($answerB));

            $nextQuestionExists = \strpos($text, $questionNumber . '. ');
            if (!$nextQuestionExists) {
                $questionNumber = 1;
            }

            $nextQuestionExists = \strpos($text, $questionNumber . '. ');
            if (!$nextQuestionExists) {
                $result[] = \array_map('trim', [$question, $answerA, $answerB, $text]);

                break;
            }

            $answerC = \substr($text, 0, \strpos($text, $questionNumber . '. '));
            $text = \substr($text, \strlen($answerC));

            $result[] = \array_map('trim', [$question, $answerA, $answerB, $answerC]);

            $questionNumber++;
        }

        return $result;
    }

    private function cutStringToFirstQuestion(string $text): string
    {
        $questionPosition = \strpos($text, '1. ');

        return \substr($text, $questionPosition);
    }

    private function getTextFromFile(string $file): string
    {
        $parser = new Parser();

        return $parser->parseFile($file)->getText();
    }

    private function removeTabs(string $text): string
    {
        return \trim(
            \preg_replace('/\t+/', '', $text)
        );
    }

    private function removeNewLines(string $text): string
    {
        return \trim(
            \preg_replace('/\n+/', '', $text)
        );
    }

    private function removeDoubleSpaces($text): string
    {
        $count = 1;

        while ($count !== 0) {
            $text = \str_replace('  ', ' ', $text, $count);
        }

        return $text;
    }
}

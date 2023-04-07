<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use App\TestStats;
use LearnByTests\Domain\Question\QuestionRepository;

class CalculateTestStatsHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(CalculateTestStats $query): TestStats
    {
        $items = $this->questionRepository->getQuestionsWithUserRelatedData(
            $query->getUserId(),
            $query->getCategory(),
            $query->getSubcategory()
        );

        $itemsCount = \count($items);
        $correctAnswersCount = 0;
        $skippedAnswersCount = 0;
        $invalidAnswersCount = 0;
        $noAnswersCount = 0;

        foreach ($items as $item) {
            if (1 === $item['is_skipped']) {
                $skippedAnswersCount++;
                continue;
            }
            if (1 === $item['is_correct']) {
                $correctAnswersCount++;
                continue;
            }
            if (0 === $item['is_correct']) {
                $invalidAnswersCount++;
                continue;
            }
            if (null === $item['is_correct']) {
                $noAnswersCount++;
            }
        }

        if ($itemsCount !== ($skippedAnswersCount + $correctAnswersCount + $invalidAnswersCount + $noAnswersCount)) {
            throw new \Exception('Given answers count does not match items count.');
        }

        return new TestStats(
            0 === $itemsCount ? 0 : (int)\round(($skippedAnswersCount / $itemsCount) * 100),
            0 === $itemsCount ? 0 : (int)\round(($correctAnswersCount / $itemsCount) * 100),
            0 === $itemsCount ? 0 : (int)\round(($invalidAnswersCount / $itemsCount) * 100)
        );
    }
}

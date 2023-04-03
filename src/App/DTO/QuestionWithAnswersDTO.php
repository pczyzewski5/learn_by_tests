<?php

declare(strict_types=1);

namespace App\DTO;

use LearnByTests\Domain\Answer\Answer;
use LearnByTests\Domain\Question\Question;
use Symfony\Component\Form\AbstractType;

class QuestionWithAnswersDTO extends AbstractType
{
    private Question $question;
    private array $answers;
    private bool $isQuestionSkipped;

    public function __construct(
        Question $question,
        array $answers,
        bool $isQuestionSkipped,
    ) {
        $this->question = $question;
        $this->answers = $answers;
        $this->isQuestionSkipped = $isQuestionSkipped;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function findAnswer(string $answerId): ?Answer
    {
        $result = null;

        /** @var Answer $answer */
        foreach ($this->answers as $answer) {
            if ($answer->getId() === $answerId) {
                $result = $answer;
            }
        }

        return $result;
    }

    /**
     * @return Answer[]
     */
    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function isQuestionSkipped(): bool
    {
        return $this->isQuestionSkipped;
    }
}

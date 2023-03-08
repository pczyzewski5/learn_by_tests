<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Answer\Exception\AnswerValidationException;
use LearnByTests\Domain\MergerTrait;
use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;
use Symfony\Component\Uid\UuidV1;

class Question
{
    use MergerTrait;

    private string $id;
    private string $question;
    private QuestionCategoryEnum $category;
    private \DateTimeImmutable $createdAt;

    public function __construct(QuestionDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(QuestionDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw AnswerValidationException::missingProperty('id');
        }
        
        if (!isset($this->question) || '' === $this->question) {
            throw AnswerValidationException::missingProperty('question');
        }

        if (!isset($this->category)) {
            throw AnswerValidationException::missingProperty('category');
        }

        if (!isset($this->createdAt)) {
            throw AnswerValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }
    
    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getCategory(): QuestionCategoryEnum
    {
        return $this->category;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

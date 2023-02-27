<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Answer;

use LearnByTests\Domain\Answer\Exception\AnswerValidationException;
use LearnByTests\Domain\MergerTrait;
use Symfony\Component\Uid\UuidV1;

class Answer
{
    use MergerTrait;

    private string $id;
    private string $questionId;
    private string $answer;
    private \DateTimeImmutable $createdAt;

    public function __construct(AnswerDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(AnswerDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (isset($this->id) && UuidV1::isValid($this->id)) {
            throw AnswerValidationException::missingProperty('id');
        }

        if (isset($this->questionId) && UuidV1::isValid($this->questionId)) {
            throw AnswerValidationException::missingProperty('question_id');
        }

        if (!isset($this->answer) || '' === $this->answer) {
            throw AnswerValidationException::missingProperty('answer');
        }

        if (!isset($this->createdAt)) {
            throw AnswerValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

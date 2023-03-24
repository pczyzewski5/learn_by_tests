<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserQuestionAnswer;

use LearnByTests\Domain\MergerTrait;
use LearnByTests\Domain\UserQuestionAnswer\Exception\UserQuestionAnswerValidationException;
use Symfony\Component\Uid\UuidV1;

class UserQuestionAnswer
{
    use MergerTrait;

    private string $userId;
    private string $questionId;
    private string $answerId;
    private \DateTimeImmutable $createdAt;

    public function __construct(UserQuestionAnswerDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(UserQuestionAnswerDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->userId) && UuidV1::isValid($this->userId)) {
            throw UserQuestionAnswerValidationException::missingProperty('user_id');
        }

        if (!isset($this->questionId) && UuidV1::isValid($this->questionId)) {
            throw UserQuestionAnswerValidationException::missingProperty('question_id');
        }

        if (!isset($this->answerId) && UuidV1::isValid($this->answerId)) {
            throw UserQuestionAnswerValidationException::missingProperty('answer_id');
        }

        if (!isset($this->createdAt)) {
            throw UserQuestionAnswerValidationException::missingProperty('createdAt');
        }
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    public function getAnswerId(): string
    {
        return $this->answerId;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

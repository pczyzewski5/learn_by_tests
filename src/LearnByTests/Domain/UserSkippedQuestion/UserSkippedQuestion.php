<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserSkippedQuestion;

use LearnByTests\Domain\MergerTrait;
use LearnByTests\Domain\UserSkippedQuestion\Exception\UserSkippedQuestionValidationException;
use Symfony\Component\Uid\UuidV1;

class UserSkippedQuestion
{
    use MergerTrait;

    private string $userId;
    private string $questionId;
    private \DateTimeImmutable $createdAt;

    public function __construct(UserSkippedQuestionDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(UserSkippedQuestionDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        if (!isset($this->userId) && UuidV1::isValid($this->userId)) {
            throw UserSkippedQuestionValidationException::missingProperty('user_id');
        }

        if (!isset($this->questionId) && UuidV1::isValid($this->questionId)) {
            throw UserSkippedQuestionValidationException::missingProperty('question_id');
        }

        if (!isset($this->createdAt)) {
            throw UserSkippedQuestionValidationException::missingProperty('createdAt');
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

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

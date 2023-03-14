<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Answer\Exception\AnswerValidationException;
use LearnByTests\Domain\MergerTrait;
use LearnByTests\Domain\Category\CategoryEnum;
use Symfony\Component\Uid\UuidV1;

class Question
{
    use MergerTrait;

    private string $id;
    private string $question;
    private string $authorId;
    private CategoryEnum $category;
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

        if (!isset($this->authorId) && UuidV1::isValid($this->authorId)) {
            throw AnswerValidationException::missingProperty('author_id');
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

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getCategory(): CategoryEnum
    {
        return $this->category;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }
}

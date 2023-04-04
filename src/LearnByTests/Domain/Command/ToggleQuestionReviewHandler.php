<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Question\QuestionDTO;
use LearnByTests\Domain\Question\QuestionPersister;
use LearnByTests\Domain\Question\QuestionRepository;

class ToggleQuestionReviewHandler
{
    private QuestionPersister $persister;
    private QuestionRepository $repository;

    public function __construct(
        QuestionPersister $persister,
        QuestionRepository $repository,
    ) {
        $this->persister = $persister;
        $this->repository = $repository;
    }

    public function handle(ToggleQuestionReview $command): void
    {
        $questionId = $command->getQuestionId();
        $question = $this->repository->getOneById($questionId);
        $dto = new QuestionDTO();

        $question->toReview()
            ? $dto->toReview = false
            : $dto->toReview = true;

        $question->update($dto);

        $this->persister->update($question);
    }
}

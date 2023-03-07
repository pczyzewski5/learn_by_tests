<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Question\QuestionDTO;
use LearnByTests\Domain\Question\QuestionPersister;
use LearnByTests\Domain\Question\QuestionRepository;

class UpdateQuestionHandler
{
    private QuestionRepository $questionRepository;
    private QuestionPersister $questionPersister;

    public function __construct(
        QuestionRepository $questionRepository,
        QuestionPersister $questionPersister
    ) {
        $this->questionRepository = $questionRepository;
        $this->questionPersister = $questionPersister;
    }

    public function handle(UpdateQuestion $command): void
    {
        $dto = new QuestionDTO();
        $dto->question = $command->getQuestion();

        $question = $this->questionRepository->getOneById($command->getQuestionId());
        $question->update($dto);

        $this->questionPersister->update($question);
    }
}

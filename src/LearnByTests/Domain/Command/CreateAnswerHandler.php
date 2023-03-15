<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerFactory;
use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Question\QuestionRepository;

class CreateAnswerHandler
{
    private QuestionRepository $questionRepository;
    private AnswerPersister $answerPersister;

    public function __construct(
        QuestionRepository $questionRepository,
        AnswerPersister $answerPersister
    ) {
        $this->questionRepository = $questionRepository;
        $this->answerPersister = $answerPersister;
    }

    public function handle(CreateAnswer $command): void
    {
        $question = $this->questionRepository->getOneById($command->getQuestionId());

        $answer = AnswerFactory::create(
            $question->getId(),
            $command->getAnswer(),
            $command->getAuthorId(),
            false,
            $command->getComment()
        );

        $this->answerPersister->save($answer);
    }
}

<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Answer\AnswerRepository;

class SetAnswerAsCorrectHandler
{
    private AnswerRepository $answerRepository;
    private AnswerPersister $answerPersister;

    public function __construct(
        AnswerRepository $answerRepository,
        AnswerPersister $answerPersister
    ) {
        $this->answerRepository = $answerRepository;
        $this->answerPersister = $answerPersister;
    }

    public function handle(SetAnswerAsCorrect $command): void
    {
        $answer = $this->answerRepository->getOneById(
            $command->getAnswerId()
        );

        $this->answerPersister->update($answer);
    }
}

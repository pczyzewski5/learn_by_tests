<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerDTO;
use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Answer\AnswerRepository;
use LearnByTests\Domain\Question\QuestionDTO;

class UpdateAnswerHandler
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

    public function handle(UpdateAnswer $command): void
    {
        $dto = new AnswerDTO();
        $dto->answer = $command->getAnswer();
        $dto->authorId = $command->getAuthorId();

        $answer = $this->answerRepository->getOneById($command->getAnswerId());
        $answer->update($dto);

        $this->answerPersister->update($answer);
    }
}

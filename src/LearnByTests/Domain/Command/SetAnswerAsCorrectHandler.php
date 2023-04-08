<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerDTO;
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
        $this->setAllAnswersAsIncorrect($command->getQuestionId());
        $this->setAnswerAsCorrect($command->getAnswerId());
    }

    public function setAnswerAsCorrect(string $answerId): void
    {
        $dto = new AnswerDTO();
        $dto->isCorrect = true;

        $answer = $this->answerRepository->getOneById($answerId);
        $answer->update($dto);

        $this->answerPersister->update($answer);
    }

    private function setAllAnswersAsIncorrect(string $questionId): void
    {
        $answers = $this->answerRepository->findForQuestion($questionId);

        foreach ($answers as $answer) {
            $dto = new AnswerDTO();
            $dto->isCorrect = false;

            $answer->update($dto);

            $this->answerPersister->update($answer);
        }
    }
}

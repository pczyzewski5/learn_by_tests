<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Question\QuestionFactory;
use LearnByTests\Domain\Question\QuestionPersister;
use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;

class CreateQuestionHandler
{
    private QuestionPersister $questionPersister;

    public function __construct(QuestionPersister $questionPersister) {
        $this->questionPersister = $questionPersister;
    }

    public function handle(CreateQuestion $command): string
    {
        $question = QuestionFactory::create(
            $command->getQuestion(),
            $command->getAuthorId(),
            QuestionCategoryEnum::UNASSIGNED(),
        );

        $this->questionPersister->save($question);

        return $question->getId();
    }
}

<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Question\QuestionFactory;
use LearnByTests\Domain\Question\QuestionPersister;
use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;

class AddQuestionHandler
{
    private QuestionPersister $questionPersister;

    public function __construct(QuestionPersister $questionPersister) {
        $this->questionPersister = $questionPersister;
    }

    public function handle(AddQuestion $command): string
    {
        $question = QuestionFactory::create(
            $command->getQuestion(),
            QuestionCategoryEnum::UNASSIGNED()
        );

        $this->questionPersister->save($question);

        return $question->getId();
    }
}

<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\Answer;
use LearnByTests\Domain\Answer\AnswerFactory;
use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Answer\AnswerRepository;
use LearnByTests\Domain\Question\Question;
use LearnByTests\Domain\Question\QuestionFactory;
use LearnByTests\Domain\Question\QuestionPersister;
use LearnByTests\Domain\Question\QuestionRepository;

class DuplicateQuestionHandler
{
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;
    private QuestionPersister $questionPersister;
    private AnswerPersister $answerPersister;

    public function __construct(
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository,
        QuestionPersister $questionPersister,
        AnswerPersister $answerPersister
    ) {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->questionPersister = $questionPersister;
        $this->answerPersister = $answerPersister;
    }

    public function handle(DuplicateQuestion $command): string
    {
        $question = $this->questionRepository->getOneById($command->getQuestionId());
        $answers = $this->answerRepository->findForQuestion($command->getQuestionId());

        $newQuestion = $this->duplicateQuestion(
            $command,
            $question
        );

        $this->duplicateAnswers(
            $command,
            $newQuestion,
            $answers
        );

        return $newQuestion->getId();
    }

    private function duplicateQuestion(
        DuplicateQuestion $command,
        Question $question
    ): Question {
        $questionText = \json_decode(
            $question->getQuestion(),
            true
        );
        \array_unshift(
            $questionText['ops'],
            ['insert' => '(dup)' . PHP_EOL]
        );

        $newQuestion = QuestionFactory::create(
            \json_encode($questionText),
            $command->getAuthorId(),
            $question->getCategory(),
            $question->getSubcategory()
        );

        $this->questionPersister->save($newQuestion);

        return $newQuestion;
    }

    private function duplicateAnswers(
        DuplicateQuestion $command,
        Question $newQuestion,
        array $answers
    ): void {
        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $newAnswer = AnswerFactory::create(
                $newQuestion->getId(),
                $answer->getAnswer(),
                $command->getAuthorId(),
                $answer->isCorrect(),
                $answer->getComment()
            );

            $this->answerPersister->save($newAnswer);
        }
    }
}

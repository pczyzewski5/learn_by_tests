<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use Doctrine\ORM\EntityManager;
use LearnByTests\Domain\Answer\AnswerFactory;
use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Exception\PersisterException;
use LearnByTests\Domain\Question\QuestionFactory;
use LearnByTests\Domain\Question\QuestionPersister;

class AddQuestionHandler
{
    private EntityManager $entityManager;
    private QuestionPersister $questionPersister;
    private AnswerPersister $answerPersister;

    public function __construct(
        EntityManager $entityManager,
        QuestionPersister $questionPersister,
        AnswerPersister $answerPersister
    ) {
        $this->entityManager = $entityManager;
        $this->questionPersister = $questionPersister;
        $this->answerPersister = $answerPersister;
    }

    public function handle(AddQuestion $command): void
    {
        $this->entityManager->beginTransaction();

        try {
            $question = QuestionFactory::create($command->getQuestion());

            $this->questionPersister->save($question);

            foreach ($command->getAnswers() as $answer) {
                $entity = AnswerFactory::create(
                    $question->getId(),
                    $answer,
                    false
                );

                $this->answerPersister->save($entity);
            }
        } catch (PersisterException $e) {
            $this->entityManager->rollback();
        }

        $this->entityManager->commit();
    }
}

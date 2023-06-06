<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use App\Controller\SrcPdfParser;
use LearnByTests\Domain\Answer\AnswerFactory;
use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Question\QuestionFactory;
use LearnByTests\Domain\Question\QuestionPersister;

class ParseSrcPdfHandler
{
    private QuestionPersister $questionPersister;
    private AnswerPersister $answerPersister;

    public function __construct(
        QuestionPersister $questionPersister,
        AnswerPersister $answerPersister
    ) {
        $this->questionPersister = $questionPersister;
        $this->answerPersister = $answerPersister;
    }

    public function handle(ParseSrcPdf $command): void
    {
        $questionWithAnswers = (new SrcPdfParser())->parse($command->getSrcPdfFileLocation());

        $cat1 = \array_splice($questionWithAnswers, 0, 174);
        $cat2 = \array_splice($questionWithAnswers, 0, 150);
        $cat3 = \array_splice($questionWithAnswers, 0, 26);

        foreach ($cat1 as $item) {
            $question = QuestionFactory::create(
                \sprintf(
                    '{"ops":[{"insert":"%s\n"}]}',
                    \trim($item['question'])
                ),
                'src_parser',
                CategoryEnum::SRC(),
                CategoryEnum::SRC_REGULATIONS()
            );
            $this->questionPersister->save($question);

            foreach ($item['answers'] as $answer) {
                $answer = AnswerFactory::create(
                    $question->getId(),
                    \sprintf(
                        '{"ops":[{"insert":"%s\n"}]}',
                        \trim($answer),
                    ),
                    'src_parser',
                    false
                );
                $this->answerPersister->save($answer);
            }
        }

        foreach ($cat2 as $item) {
            $question = QuestionFactory::create(
                \sprintf(
                    '{"ops":[{"insert":"%s\n"}]}',
                    \trim($item['question'])
                ),
                'src_parser',
                CategoryEnum::SRC(),
                CategoryEnum::SRC_COMMON_WISDOM()
            );
            $this->questionPersister->save($question);

            foreach ($item['answers'] as $answer) {
                $answer = AnswerFactory::create(
                    $question->getId(),
                    \sprintf(
                        '{"ops":[{"insert":"%s\n"}]}',
                        \trim($answer),
                    ),
                    'src_parser',
                    false
                );
                $this->answerPersister->save($answer);
            }
        }

        foreach ($cat3 as $item) {
            $question = QuestionFactory::create(
                \sprintf(
                    '{"ops":[{"insert":"%s\n"}]}',
                    \trim($item['question'])
                ),
                'src_parser',
                CategoryEnum::SRC(),
                CategoryEnum::SRC_RADIO_HANDLING()
            );
            $this->questionPersister->save($question);

            foreach ($item['answers'] as $answer) {
                $answer = AnswerFactory::create(
                    $question->getId(),
                    \sprintf(
                        '{"ops":[{"insert":"%s\n"}]}',
                        \trim($answer),
                    ),
                    'src_parser',
                    false
                );
                $this->answerPersister->save($answer);
            }
        }
    }
}

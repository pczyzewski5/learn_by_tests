<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use App\Controller\SrcPdfParser;
use LearnByTests\Domain\Answer\Answer;
use LearnByTests\Domain\Answer\AnswerFactory;
use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Question\Question;
use LearnByTests\Domain\Question\QuestionFactory;
use LearnByTests\Domain\Question\QuestionPersister;

class ParseSrcPdfHandler
{
    private array $cat1ValidAnswers = [1 => 'B', 45 => 'C', 89 => 'B', 133 => 'C', 2 => 'B', 46 => 'B', 90 => 'A', 134 => 'B', 3 => 'C', 47 => 'A', 91 => 'B', 135 => 'C', 4 => 'C', 48 => 'C', 92 => 'B', 136 => 'C', 5 => 'B', 49 => 'A', 93 => 'A', 137 => 'C', 6 => 'C', 50 => 'C', 94 => 'A', 138 => 'C', 7 => 'C', 51 => 'B', 95 => 'A', 139 => 'C', 8 => 'B', 52 => 'C', 96 => 'B', 140 => 'B', 9 => 'C', 53 => 'B', 97 => 'C', 141 => 'C', 10 => 'C', 54 => 'C', 98 => 'C', 142 => 'A', 11 => 'A', 55 => 'B', 99 => 'B', 143 => 'A', 12 => 'A', 56 => 'C', 100 => 'C', 144 => 'C', 13 => 'C', 57 => 'C', 101 => 'C', 145 => 'B', 14 => 'B', 58 => 'C', 102 => 'C', 146 => 'C', 15 => 'C', 59 => 'B', 103 => 'B', 147 => 'B', 16 => 'B', 60 => 'C', 104 => 'A', 148 => 'A', 17 => 'C', 61 => 'A', 105 => 'B', 149 => 'B', 18 => 'B', 62 => 'C', 106 => 'C', 150 => 'A', 19 => 'C', 63 => 'A', 107 => 'A', 151 => 'B', 20 => 'C', 64 => 'C', 108 => 'B', 152 => 'B', 21 => 'B', 65 => 'B', 109 => 'C', 153 => 'B', 22 => 'A', 66 => 'C', 110 => 'B', 154 => 'B', 23 => 'C', 67 => 'C', 111 => 'C', 155 => 'C', 24 => 'C', 68 => 'C', 112 => 'B', 156 => 'C', 25 => 'C', 69 => 'B', 113 => 'A', 157 => 'C', 26 => 'A', 70 => 'B', 114 => 'C', 158 => 'A', 27 => 'C', 71 => 'C', 115 => 'B', 159 => 'B', 28 => 'B', 72 => 'A', 116 => 'C', 160 => 'A', 29 => 'C', 73 => 'A', 117 => 'C', 161 => 'B', 30 => 'C', 74 => 'C', 118 => 'B', 162 => 'C', 31 => 'A', 75 => 'A', 119 => 'C', 163 => 'A', 32 => 'B', 76 => 'C', 120 => 'B', 164 => 'C', 33 => 'B', 77 => 'C', 121 => 'C', 165 => 'C', 34 => 'B', 78 => 'A', 122 => 'A', 166 => 'C', 35 => 'A', 79 => 'A', 123 => 'C', 167 => 'B', 36 => 'A', 80 => 'C', 124 => 'A', 168 => 'C', 37 => 'C', 81 => 'C', 125 => 'C', 169 => 'C', 38 => 'C', 82 => 'C', 126 => 'B', 170 => 'C', 39 => 'B', 83 => 'A', 127 => 'C', 171 => 'B', 40 => 'B', 84 => 'A', 128 => 'C', 172 => 'A', 41 => 'C', 85 => 'B', 129 => 'C', 173 => 'A', 42 => 'B', 86 => 'C', 130 => 'A', 174 => 'C', 43 => 'A', 87 => 'A', 131 => 'A', 44 => 'C', 88 => 'C', 132 => 'B'];
    private array $cat2ValidAnswers = [1 => 'A', 45 => 'B', 89 => 'B', 133 => 'C', 2 => 'C', 46 => 'C', 90 => 'A', 134 => 'B', 3 => 'C', 47 => 'C', 91 => 'B', 135 => 'A', 4 => 'C', 48 => 'A', 92 => 'B', 136 => 'A', 5 => 'B', 49 => 'A', 93 => 'A', 137 => 'A', 6 => 'B', 50 => 'A', 94 => 'B', 138 => 'C', 7 => 'C', 51 => 'B', 95 => 'B', 139 => 'C', 8 => 'A', 52 => 'A', 96 => 'C', 140 => 'B', 9 => 'A', 53 => 'A', 97 => 'C', 141 => 'A', 10 => 'B', 54 => 'C', 98 => 'A', 142 => 'A', 11 => 'A', 55 => 'C', 99 => 'B', 143 => 'B', 12 => 'B', 56 => 'A', 100 => 'C', 144 => 'B', 13 => 'C', 57 => 'A', 101 => 'C', 145 => 'B', 14 => 'A', 58 => 'B', 102 => 'C', 146 => 'A', 15 => 'B', 59 => 'A', 103 => 'A', 147 => 'C', 16 => 'B', 60 => 'A', 104 => 'C', 148 => 'A', 17 => 'A', 61 => 'C', 105 => 'C', 149 => 'A', 18 => 'C', 62 => 'C', 106 => 'A', 150 => 'A', 19 => 'A', 63 => 'B', 107 => 'A', 20 => 'B', 64 => 'A', 108 => 'C', 21 => 'B', 65 => 'A', 109 => 'B', 22 => 'B', 66 => 'B', 110 => 'C', 23 => 'A', 67 => 'B', 111 => 'C', 24 => 'A', 68 => 'B', 112 => 'C', 25 => 'B', 69 => 'A', 113 => 'C', 26 => 'B', 70 => 'C', 114 => 'B', 27 => 'A', 71 => 'A', 115 => 'B', 28 => 'A', 72 => 'A', 116 => 'A', 29 => 'C', 73 => 'A', 117 => 'B', 30 => 'B', 74 => 'A', 118 => 'A', 31 => 'B', 75 => 'C', 119 => 'A', 32 => 'A', 76 => 'C', 120 => 'A', 33 => 'C', 77 => 'B', 121 => 'C', 34 => 'B', 78 => 'A', 122 => 'A', 35 => 'C', 79 => 'A', 123 => 'B', 36 => 'B', 80 => 'A', 124 => 'A', 37 => 'B', 81 => 'A', 125 => 'A', 38 => 'A', 82 => 'B', 126 => 'B', 39 => 'A', 83 => 'B', 127 => 'B', 40 => 'A', 84 => 'A', 128 => 'B', 41 => 'C', 85 => 'B', 129 => 'B', 42 => 'C', 86 => 'B', 130 => 'A', 43 => 'B', 87 => 'A', 131 => 'A', 44 => 'A', 88 => 'C', 132 => 'C'];
    private array $cat3ValidAnswers = [1 => 'A', 2 => 'B', 3 => 'A', 4 => 'B', 5 => 'C', 6 => 'C', 7 => 'A', 8 => 'B', 9 => 'A', 10 => 'B', 11 => 'B', 12 => 'C', 13 => 'C', 14 => 'C', 15 => 'A', 16 => 'A', 17 => 'B', 18 => 'C', 19 => 'A', 20 => 'B', 21 => 'C', 22 => 'A', 23 => 'A', 24 => 'C', 25 => 'B', 26 => 'A'];
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
        $result = (new SrcPdfParser())->parse($command->getSrcPdfFileLocation());

        $cat1 = \array_splice($result, 0, 174);
        $cat2 = \array_splice($result, 0, 150);
        $cat3 = \array_splice($result, 0, 26);

        foreach ($cat1 as $item) {
            $question = $item['question'];

            $questionEntity = $this->createQuestionEntity(
                $question,
                CategoryEnum::SRC_REGULATIONS()
            );
            $this->questionPersister->save($questionEntity);

            foreach ($item['answers'] as $answer) {
                $answerEntity = $this->createAnswerEntity(
                    $questionEntity,
                    $question,
                    $answer,
                    $this->cat1ValidAnswers
                );
                $this->answerPersister->save($answerEntity);
            }
        }

        foreach ($cat2 as $item) {
            $question = $item['question'];

            $questionEntity = $this->createQuestionEntity(
                $question,
                CategoryEnum::SRC_COMMON_WISDOM()
            );
            $this->questionPersister->save($questionEntity);

            foreach ($item['answers'] as $answer) {
                $answerEntity = $this->createAnswerEntity(
                    $questionEntity,
                    $question,
                    $answer,
                    $this->cat2ValidAnswers
                );
                $this->answerPersister->save($answerEntity);
            }
        }

        foreach ($cat3 as $item) {
            $question = $item['question'];

            $questionEntity = $this->createQuestionEntity(
                $question,
                CategoryEnum::SRC_RADIO_HANDLING()
            );
            $this->questionPersister->save($questionEntity);

            foreach ($item['answers'] as $answer) {
                $answerEntity = $this->createAnswerEntity(
                    $questionEntity,
                    $question,
                    $answer,
                    $this->cat3ValidAnswers
                );
                $this->answerPersister->save($answerEntity);
            }
        }
    }

    private function createQuestionEntity(
        string $question,
        CategoryEnum $subcategory
    ): Question {
        $question = \substr($question, \strpos($question, '. ') + 2);
        $question = \trim($question);
        $question = \sprintf(
            '{"ops":[{"insert":"%s\n"}]}',
            \trim($question)
        );

        $entity = QuestionFactory::create(
            $question,
            'src_parser',
            CategoryEnum::SRC(),
            $subcategory
        );

        return $entity;
    }

    private function createAnswerEntity(
        Question $questionEntity,
        string $question,
        string $answer,
        array $validAnswers
    ): Answer {
        $questionNumber = \intval(
            \substr($question, 0, \strpos($question, '. '))
        );
        $answerLetter = \substr($answer, 0, \strpos($answer, '. '));

        if (!\array_key_exists($questionNumber, $validAnswers)) {
            throw new \Exception('Question not found in valid answers');
        }
        $isCorrect = $validAnswers[$questionNumber] === $answerLetter;

        $answer = \substr($answer, \strpos($answer, '. ') + 2);
        $answer = \trim($answer);
        $answer = \sprintf(
            '{"ops":[{"insert":"%s\n"}]}',
            \trim($answer),
        );

        $entity = AnswerFactory::create(
            $questionEntity->getId(),
            $answer,
            'src_parser',
            $isCorrect
        );

        return $entity;
    }
}

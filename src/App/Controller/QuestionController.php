<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\Form\Question\AddQuestionForm;
use App\Form\Question\ValidAnswerForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\AddQuestion;
use LearnByTests\Domain\Command\SetAnswerAsValid;
use LearnByTests\Domain\Query\GetQuestions;
use LearnByTests\Domain\Query\GetQuestionWithAnswers;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function questionList(): Response
    {
        return $this->renderForm('question/question_list.html.twig', [
            'questions' => $this->queryBus->handle(
                new GetQuestions()
            )
        ]);
    }

    public function addQuestion(Request $request): Response
    {
        $form = $this->createForm(AddQuestionForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->commandBus->handle(
                new AddQuestion(
                    $data[AddQuestionForm::QUESTION_FILED],
                    $data[AddQuestionForm::ANSWER_A],
                    $data[AddQuestionForm::ANSWER_B],
                    $data[AddQuestionForm::ANSWER_C],
                    $data[AddQuestionForm::ANSWER_D],
                )
            );
        }

        return $this->renderForm('question/add_question.html.twig', [
            'add_question' => $form,
        ]);
    }

    public function selectValidAnswer(Request $request): Response
    {
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );
        $form = $this->createForm(
            ValidAnswerForm::class,
            null,
            ['data' => $dto->getAnswers()]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new SetAnswerAsValid(
                    $form->getData()[ValidAnswerForm::VALID_ANSWER]
                )
            );
        }

        return $this->renderForm('question/select_valid_answer.html.twig', [
            'valid_answer' => $form,
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers()
        ]);
    }
}

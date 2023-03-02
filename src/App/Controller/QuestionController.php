<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\Question\AddQuestionForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\AddQuestion;
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

    public function add(Request $request): Response
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

        return $this->renderForm('question/add.html.twig', [
            'add_question' => $form,
        ]);
    }
}

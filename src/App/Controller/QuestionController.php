<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\Form\Question\QuestionForm;
use App\Form\Question\AnswerForm;
use App\Form\Question\CorrectAnswerForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\AddQuestion;
use LearnByTests\Domain\Command\AddAnswer;
use LearnByTests\Domain\Command\DeleteQuestion;
use LearnByTests\Domain\Command\SetAnswerAsCorrect;
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

    public function questionDetails(Request $request): Response
    {
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );

        return $this->renderForm('question/question_details.twig', [
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers()
        ]);
    }


    public function addQuestion(Request $request): Response
    {
        $form = $this->createForm(QuestionForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionId = $this->commandBus->handle(
                new AddQuestion(
                    $form->getData()[QuestionForm::ADD_QUESTION_FIELD]
                )
            );

            return $this->redirectToRoute(
                'question_add_answer',
                ['questionId' => $questionId]
            );
        }

        return $this->renderForm('question/add_question.html.twig', [
            'add_question' => $form,
        ]);
    }

    public function addQuestionAnswer(Request $request): Response
    {
        $questionId = $request->get('questionId');
        /** @var QuestionWithAnswersDTO $questionWithAnswersDTO */
        $questionWithAnswersDTO = $this->queryBus->handle(
            new GetQuestionWithAnswers($questionId)
        );
        $hasAllAnswers = \count($questionWithAnswersDTO->getAnswers()) === 4;
        if ($hasAllAnswers) {
            return $this->redirectToRoute('question_select_correct_answer', ['questionId' => $questionId]);
        }
        $form = $this->createForm(AnswerForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new AddAnswer(
                    $questionId,
                    $form->getData()[AnswerForm::ADD_NEXT_ANSWER_FIELD],
                )
            );

            $redirectTo = $hasAllAnswers
                ? $this->redirectToRoute('question_select_correct_answer', ['questionId' => $questionId])
                : $this->redirectToRoute('question_add_answer', ['questionId' => $questionId]);

            return $redirectTo;
        }

        return $this->renderForm('question/add_question_answer.html.twig', [
            'add_question_answers' => $form,
            'question' => $questionWithAnswersDTO->getQuestion(),
            'answers' => $questionWithAnswersDTO->getAnswers()
        ]);
    }

    public function questionSelectCorrectAnswer(Request $request): Response
    {
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );
        $form = $this->createForm(
            CorrectAnswerForm::class,
            null,
            ['data' => $dto->getAnswers()]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new SetAnswerAsCorrect(
                    $form->getData()[CorrectAnswerForm::IS_CORRECT_ANSWER_FIELD]
                )
            );

            return $this->redirectToRoute('question_list');
        }

        return $this->renderForm('question/select_correct_answer.html.twig', [
            'correct_answer' => $form,
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers()
        ]);
    }

    public function deleteQuestion(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteQuestion($request->get('questionId'))
        );

        return $this->redirectToRoute('question_list');
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\Form\Question\QuestionCategoryForm;
use App\Form\Question\QuestionForm;
use App\Form\Question\AnswerForm;
use App\Form\Question\CorrectAnswerForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\AddQuestion;
use LearnByTests\Domain\Command\AddAnswer;
use LearnByTests\Domain\Command\DeleteAnswer;
use LearnByTests\Domain\Command\DeleteQuestion;
use LearnByTests\Domain\Command\SetAnswerAsCorrect;
use LearnByTests\Domain\Command\UpdateAnswer;
use LearnByTests\Domain\Command\UpdateQuestion;
use LearnByTests\Domain\Query\GetQuestions;
use LearnByTests\Domain\Query\GetQuestionWithAnswers;
use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;
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

    public function questionSelectCorrectAnswer(Request $request): Response
    {
        $questionId = $request->get('questionId');
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($questionId)
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
                    $questionId,
                    $form->getData()[CorrectAnswerForm::IS_CORRECT_ANSWER_FIELD]
                )
            );

            return $this->redirectToRoute('question_select_category', ['questionId' => $questionId]);
        }

        return $this->renderForm('question/select_correct_answer.html.twig', [
            'correct_answer' => $form,
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers()
        ]);
    }

    public function setAnswerAsCorrect(Request $request): Response
    {
        $this->commandBus->handle(
            new SetAnswerAsCorrect(
                $request->get('questionId'),
                $request->get('answerId')
            )
        );

        return $this->redirectToRoute('question_details', ['questionId' => $request->get('questionId')]);
    }

    public function deleteQuestionAnswer(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteAnswer($request->get('answerId'))
        );

        return $this->redirectToRoute('question_details', ['questionId' => $request->get('questionId')]);
    }

    public function editQuestion(Request $request): Response
    {
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );
        $question = $dto->getQuestion();

        $form = $this->createForm(
            QuestionForm::class,
            [QuestionForm::QUESTION_FIELD => $question->getQuestion()]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new UpdateQuestion(
                    $question->getId(),
                    $form->getData()[QuestionForm::QUESTION_FIELD]
                )
            );

            return $this->redirectToRoute('question_details', ['questionId' => $question->getId()]);
        }

        return $this->renderForm('question/edit_question.twig', [
            'edit_question_form' => $form,
            'question' => $question,
            'answers' => $dto->getAnswers()
        ]);
    }

    public function editQuestionAnswer(Request $request): Response
    {
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );
        $question = $dto->getQuestion();
        $answer = $dto->findAnswer(
            $request->get('answerId')
        );

        $form = $this->createForm(
            AnswerForm::class,
            [AnswerForm::ANSWER_FIELD => $answer->getAnswer()]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new UpdateAnswer(
                    $answer->getId(),
                    $form->getData()[AnswerForm::ANSWER_FIELD]
                )
            );

            return $this->redirectToRoute('question_details', ['questionId' => $question->getId()]);
        }

        return $this->renderForm('question/edit_question_answer.twig', [
            'edit_answer_form' => $form,
            'question' => $question,
            'answerId' => $answer->getId(),
            'answers' => $dto->getAnswers()
        ]);
    }

    public function selectQuestionCategory(Request $request): Response
    {
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );
        $question = $dto->getQuestion();

        $form = $this->createForm(
            QuestionCategoryForm::class
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new UpdateQuestion(
                    $question->getId(),
                    $question->getQuestion(),
                    $form->getData()[QuestionCategoryForm::QUESTION_CATEGORY_FIELD]
                )
            );

            return $this->redirectToRoute('question_details', ['questionId' => $question->getId()]);
        }

        return $this->renderForm('question/select_question_category.twig', [
            'select_question_category_form' => $form,
            'question' => $question,
            'answers' => $dto->getAnswers(),
            'question_categories' => QuestionCategoryEnum::toArray()
        ]);
    }
}

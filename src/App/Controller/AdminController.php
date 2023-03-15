<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\Form\Question\AnswerForm;
use App\Form\Question\CorrectAnswerForm;
use App\Form\Question\CategoryForm;
use App\Form\Question\QuestionForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\CreateAnswer;
use LearnByTests\Domain\Command\CreateQuestion;
use LearnByTests\Domain\Command\DeleteAnswer;
use LearnByTests\Domain\Command\DeleteQuestion;
use LearnByTests\Domain\Command\SetAnswerAsCorrect;
use LearnByTests\Domain\Command\UpdateAnswer;
use LearnByTests\Domain\Command\UpdateQuestion;
use LearnByTests\Domain\Query\GetCategories;
use LearnByTests\Domain\Query\FindQuestions;
use LearnByTests\Domain\Query\GetQuestionWithAnswers;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Query\GetSubCategories;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function categoryList(): Response
    {
        return $this->renderForm('admin/category_list.html.twig', [
            'categories' => $this->queryBus->handle(
                new GetCategories()
            )
        ]);
    }

    public function questionList(Request $request): Response
    {
        $subcategory = $request->get('subcategory');
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategories = $this->queryBus->handle(
            new GetSubCategories($category)
        );
        $questions = $this->queryBus->handle(
            new FindQuestions(
                $category,
                null === $subcategory
                    ? null
                    : CategoryEnum::fromLowerKey($subcategory)
            )
        );

        return $this->renderForm('admin/question_list.html.twig', [
            'category' => $category,
            'subcategories' => $subcategories,
            'active_subcategory' => $subcategory,
            'questions' => $questions,
        ]);
    }

    public function questionDetails(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );

        return $this->renderForm('admin/question_details.twig', [
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers(),
            'category' => $category
        ]);
    }

    public function deleteQuestion(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $this->commandBus->handle(
            new DeleteQuestion($request->get('questionId'))
        );

        return $this->redirectToRoute('question_list', ['category' => $category->getLowerKey()]);
    }

    public function createQuestion(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $form = $this->createForm(QuestionForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionId = $this->commandBus->handle(
                new CreateQuestion(
                    $category,
                    $form->getData()[QuestionForm::QUESTION_FIELD],
                    $this->getUser()->getId()
                )
            );

            return $this->redirectToRoute(
                'create_answer', [
                'questionId' => $questionId,
                'category' => $category->getLowerKey()
            ]);
        }

        return $this->renderForm('admin/create_question.html.twig', [
            'create_question_form' => $form,
            'category' => $category
        ]);
    }

    public function createAnswer(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $questionId = $request->get('questionId');
        /** @var QuestionWithAnswersDTO $questionWithAnswersDTO */
        $questionWithAnswersDTO = $this->queryBus->handle(
            new GetQuestionWithAnswers($questionId)
        );
        $hasAllAnswers = \count($questionWithAnswersDTO->getAnswers()) === 4;
        if ($hasAllAnswers) {
            return $this->redirectToRoute('select_correct_answer', ['category' => $category->getLowerKey(), 'questionId' => $questionId]);
        }
        $form = $this->createForm(AnswerForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new CreateAnswer(
                    $questionId,
                    $form->getData()[AnswerForm::ANSWER_FIELD],
                    $this->getUser()->getId(),
                    $form->getData()[AnswerForm::COMMENT_FIELD],
                )
            );

            return $this->redirectToRoute('create_answer', ['category' => $category->getLowerKey(), 'questionId' => $questionId]);
        }

        return $this->renderForm('admin/create_answer.html.twig', [
            'answer_form' => $form,
            'question' => $questionWithAnswersDTO->getQuestion(),
            'answers' => $questionWithAnswersDTO->getAnswers(),
            'category' => $category
        ]);
    }

    public function selectCorrectAnswer(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
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

            return $this->redirectToRoute('select_question_category', ['category' => $category->getLowerKey(), 'questionId' => $questionId]);
        }

        return $this->renderForm('admin/select_correct_answer.html.twig', [
            'correct_answer' => $form,
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers(),
            'category' => $category
        ]);
    }

    public function selectQuestionCategory(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategories = $this->queryBus->handle(
            new GetSubCategories($category)
        );
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );
        $question = $dto->getQuestion();

        $form = $this->createForm(
            CategoryForm::class
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subcategory = CategoryEnum::from(
                $form->getData()[CategoryForm::CATEGORY_FIELD]
            );
            $this->commandBus->handle(
                new UpdateQuestion(
                    $question->getId(),
                    $question->getQuestion(),
                    $this->getUser()->getId(),
                    $subcategory
                )
            );

            return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $question->getId()]);
        }

        return $this->renderForm('admin/select_question_category.twig', [
            'select_question_category_form' => $form,
            'question' => $question,
            'answers' => $dto->getAnswers(),
            'subcategories' => $subcategories,
            'category' => $category
        ]);
    }

    public function updateQuestionCategory(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategories = $this->queryBus->handle(
            new GetSubCategories($category)
        );
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );
        $question = $dto->getQuestion();

        $form = $this->createForm(
            CategoryForm::class
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $subcategory = CategoryEnum::from(
                $form->getData()[CategoryForm::CATEGORY_FIELD]
            );
            $this->commandBus->handle(
                new UpdateQuestion(
                    $question->getId(),
                    $question->getQuestion(),
                    $this->getUser()->getId(),
                    $subcategory
                )
            );

            return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $question->getId()]);
        }

        return $this->renderForm('admin/update_question_category.twig', [
            'select_question_category_form' => $form,
            'question' => $question,
            'answers' => $dto->getAnswers(),
            'subcategories' => $subcategories,
            'category' => $category
        ]);
    }

    public function updateQuestion(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
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
                    $form->getData()[QuestionForm::QUESTION_FIELD],
                    $this->getUser()->getId(),
                    $question->getSubcategory()
                )
            );

            return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $question->getId()]);
        }

        return $this->renderForm('admin/update_question.html.twig', [
            'edit_question_form' => $form,
            'question' => $question,
            'answers' => $dto->getAnswers(),
            'category' => $category
        ]);
    }

    public function setAnswerAsCorrect(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $this->commandBus->handle(
            new SetAnswerAsCorrect(
                $request->get('questionId'),
                $request->get('answerId')
            )
        );

        return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $request->get('questionId')]);
    }

    public function updateAnswer(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
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
                    $form->getData()[AnswerForm::ANSWER_FIELD],
                    $this->getUser()->getId(),
                    $form->getData()[AnswerForm::COMMENT_FIELD],
                )
            );

            return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $question->getId()]);
        }

        return $this->renderForm('admin/update_answer.twig', [
            'answer_form' => $form,
            'question' => $question,
            'answerId' => $answer->getId(),
            'answers' => $dto->getAnswers(),
            'category' => $category
        ]);
    }

    public function addAnswer(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $questionId = $request->get('questionId');
        /** @var QuestionWithAnswersDTO $questionWithAnswersDTO */
        $questionWithAnswersDTO = $this->queryBus->handle(
            new GetQuestionWithAnswers($questionId)
        );
        $hasAllAnswers = \count($questionWithAnswersDTO->getAnswers()) === 4;
        if ($hasAllAnswers) {
            return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $questionId]);
        }
        $form = $this->createForm(AnswerForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->commandBus->handle(
                new CreateAnswer(
                    $questionId,
                    $form->getData()[AnswerForm::ANSWER_FIELD],
                    $this->getUser()->getId()
                )
            );

            return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $questionId]);
        }

        return $this->renderForm('admin/add_answer.html.twig', [
            'answer_form' => $form,
            'question' => $questionWithAnswersDTO->getQuestion(),
            'answers' => $questionWithAnswersDTO->getAnswers(),
            'category' => $category
        ]);
    }

    public function deleteAnswer(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $this->commandBus->handle(
            new DeleteAnswer($request->get('answerId'))
        );

        return $this->redirectToRoute('question_details', ['category' => $category->getLowerKey(), 'questionId' => $request->get('questionId')]);
    }
}



<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\Form\Question\SelectAnswerForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Command\CreateUserQuestionAnswer;
use LearnByTests\Domain\Command\DeleteUserQuestionAnswers;
use LearnByTests\Domain\Query\FindQuestionForTest;
use LearnByTests\Domain\Query\GetCategories;
use LearnByTests\Domain\Query\GetQuestionWithAnswers;
use LearnByTests\Domain\Query\GetSubCategories;
use LearnByTests\Domain\Query\UnderDev;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
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
        return $this->renderForm('user/category_list.html.twig', [
            'categories' => $this->queryBus->handle(
                new GetCategories()
            )
        ]);
    }

    public function questionList(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategory = null !== $request->get('subcategory')
            ? CategoryEnum::fromLowerKey($request->get('subcategory'))
            : null;

        $user = $this->getUser();

        $questions = $this->queryBus->handle(
            new UnderDev(
                $user->getId(),
                $category,
                $subcategory
            )
        );
        $nextQuestion = $this->queryBus->handle(
            new FindQuestionForTest(
                $user->getId(),
                $category,
                $subcategory
            )
        );
        $subcategories = $this->queryBus->handle(
            new GetSubCategories($category)
        );

        return $this->renderForm('user/question_list.html.twig', [
            'category' => $category,
            'subcategories' => $subcategories,
            'questions' => $questions,
            'next_question' => $nextQuestion
        ]);
    }

    public function questionCategoryList(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategory = null !== $request->get('subcategory')
            ? CategoryEnum::fromLowerKey($request->get('subcategory'))
            : null;

        $user = $this->getUser();

        $questions = $this->queryBus->handle(
            new UnderDev(
                $user->getId(),
                $category,
                $subcategory
            )
        );
        $nextQuestion = $this->queryBus->handle(
            new FindQuestionForTest(
                $user->getId(),
                $category,
                $subcategory
            )
        );
        $subcategories = $this->queryBus->handle(
            new GetSubCategories($category)
        );

        return $this->renderForm('user/question_category_list.html.twig', [
            'active_subcategory' => $subcategory->getLowerKey(),
            'subcategories' => $subcategories,
            'next_question' => $nextQuestion,
            'category' => $category,
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

        return $this->renderForm('user/question_details.twig', [
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers(),
            'category' => $category
        ]);
    }

    public function deleteUserQuestionAnswers(Request $request): Response
    {
        $category = $request->get('category');
        $subcategory = $request->get('subcategory');

        $this->commandBus->handle(
            new DeleteUserQuestionAnswers(
                $this->getUser()->getId(),
                CategoryEnum::fromLowerKey($category),
                null !== $subcategory
                    ? CategoryEnum::fromLowerKey($subcategory)
                    : null,
            )
        );

        if (null === $request->get('subcategory')) {
            return $this->redirectToRoute('user_question_list', ['category' => $category]);
        }

        return $this->redirectToRoute('user_question_category_list', ['category' => $category, 'subcategory' => $subcategory]);
    }

    public function allCategoriesTest(Request $request): Response
    {
        $user = $this->getUser();
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $question = $this->queryBus->handle(
            new GetQuestionWithAnswers(
                $request->get('questionId')
            )
        );
        $answers = $question->getAnswers();
        \shuffle($answers);

        $form = $this->createForm(
            SelectAnswerForm::class,
            $answers
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->commandBus->handle(
                new CreateUserQuestionAnswer(
                    $user->getId(),
                    $question->getQuestion()->getId(),
                    $data[SelectAnswerForm::SELECTED_ANSWER_FIELD]
                )
            );

            $nextQuestion = $this->queryBus->handle(
                new FindQuestionForTest(
                    $user->getId(),
                    $category
                )
            );

            if (null === $nextQuestion) {
                return $this->redirectToRoute('user_question_list', ['category' => $category->getLowerKey()]);
            }

            $sortedAnswers = [];
            foreach (\json_decode($data[SelectAnswerForm::ANSWERS_ORDER_FIELD], true) as $answerId) {
                foreach ($answers as $answer) {
                    if ($answer->getId() === $answerId) {
                        $sortedAnswers[] = $answer;
                    }
                }
            }

            return $this->renderForm('user/all_categories_test.twig', [
                'selected_answer_id' => $form->getData()[SelectAnswerForm::SELECTED_ANSWER_FIELD],
                'answers_order' => $form->getData()[SelectAnswerForm::ANSWERS_ORDER_FIELD],
                'question' => $question->getQuestion(),
                'next_question' => $nextQuestion,
                'show_answer_details' => true,
                'answers' => $sortedAnswers,
                'show_answer_id' => false,
                'category' => $category,
            ]);
        }

        return $this->renderForm('user/all_categories_test.twig', [
            'question' => $question->getQuestion(),
            'show_answer_details' => false,
            'show_correct_answer' => false,
            'select_answer_form' => $form,
            'show_answer_id' => true,
            'category' => $category,
            'answers' => $answers,
        ]);
    }

    public function singleCategoryTest(Request $request): Response
    {
        $user = $this->getUser();
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategory = CategoryEnum::fromLowerKey(
            $request->get('subcategory')
        );
        $question = $this->queryBus->handle(
            new GetQuestionWithAnswers(
                $request->get('questionId')
            )
        );
        $answers = $question->getAnswers();
        \shuffle($answers);

        $form = $this->createForm(
            SelectAnswerForm::class,
            $answers
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $this->commandBus->handle(
                new CreateUserQuestionAnswer(
                    $user->getId(),
                    $question->getQuestion()->getId(),
                    $data[SelectAnswerForm::SELECTED_ANSWER_FIELD]
                )
            );

            $nextQuestion = $this->queryBus->handle(
                new FindQuestionForTest(
                    $user->getId(),
                    $category,
                    $subcategory
                )
            );

            if (null === $nextQuestion) {
                return $this->redirectToRoute('user_question_category_list', [
                    'category' => $category->getLowerKey(),
                    'subcategory' => $subcategory->getLowerKey()
                ]);
            }

            $sortedAnswers = [];
            foreach (\json_decode($data[SelectAnswerForm::ANSWERS_ORDER_FIELD], true) as $answerId) {
                foreach ($answers as $answer) {
                    if ($answer->getId() === $answerId) {
                        $sortedAnswers[] = $answer;
                    }
                }
            }

            return $this->renderForm('user/subcategory_test.twig', [
                'selected_answer_id' => $form->getData()[SelectAnswerForm::SELECTED_ANSWER_FIELD],
                'answers_order' => $form->getData()[SelectAnswerForm::ANSWERS_ORDER_FIELD],
                'question' => $question->getQuestion(),
                'next_question' => $nextQuestion,
                'subcategory' => $subcategory,
                'show_answer_details' => true,
                'answers' => $sortedAnswers,
                'show_answer_id' => false,
                'category' => $category,
            ]);
        }

        return $this->renderForm('user/subcategory_test.twig', [
            'question' => $question->getQuestion(),
            'show_answer_details' => false,
            'show_correct_answer' => false,
            'select_answer_form' => $form,
            'subcategory' => $subcategory,
            'show_answer_id' => true,
            'category' => $category,
            'answers' => $answers,
        ]);
    }
}

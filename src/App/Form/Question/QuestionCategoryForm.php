<?php

declare(strict_types=1);

namespace App\Form\Question;

use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionCategoryForm extends AbstractType
{
    public const QUESTION_CATEGORY_FIELD = 'question_category';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addSelectQuestionCategory($builder);

        $builder->add('save', SubmitType::class,
            [
                'disabled' => true,
                'attr' => ['class' => 'w-100 btn-primary']
            ]
        );
    }

    protected function addSelectQuestionCategory(FormBuilderInterface $builder): void
    {
        $choices = \array_combine(
            QuestionCategoryEnum::toArray(),
            QuestionCategoryEnum::toArray()
        );

        $builder->add(
            self::QUESTION_CATEGORY_FIELD,
            ChoiceType::class,
            [
                'choices' => $choices,
                'required' => true,
                'attr' => [
//                    'hidden' => true,
                ],
                'label_attr' => [
                    'hidden' => true
                ]
            ]
        );
    }
}

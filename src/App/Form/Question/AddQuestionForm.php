<?php

declare(strict_types=1);

namespace App\Form\Question;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class AddQuestionForm extends AbstractType
{
    public const QUESTION_FILED = 'question';
    public const ANSWER_A = 'answer_a';
    public const ANSWER_B = 'answer_b';
    public const ANSWER_C = 'answer_c';
    public const ANSWER_D = 'answer_d';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addQuestion($builder);
        $this->addAnswers($builder);

        $builder->add('save', SubmitType::class);
    }

    protected function addQuestion(FormBuilderInterface $builder): void
    {
        $builder->add(self::QUESTION_FILED, TextareaType::class);
    }

    protected function addAnswers(FormBuilderInterface $builder): void
    {
        $builder
            ->add(self::ANSWER_A, TextareaType::class)
            ->add(self::ANSWER_B, TextareaType::class)
            ->add(self::ANSWER_C, TextareaType::class)
            ->add(self::ANSWER_D, TextareaType::class);
    }
}

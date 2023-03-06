<?php

declare(strict_types=1);

namespace App\Form\Question;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionForm extends AbstractType
{
    public const ADD_QUESTION_FIELD = 'add_question';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addQuestion($builder);

        $builder->add('save', SubmitType::class);
    }

    protected function addQuestion(FormBuilderInterface $builder): void
    {
        $builder->add(
            self::ADD_QUESTION_FIELD,
            TextareaType::class,
            [
                'label_attr' => [
                    'hidden' => true
                ]
            ]
        );
    }
}

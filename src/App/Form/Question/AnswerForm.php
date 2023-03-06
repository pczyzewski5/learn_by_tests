<?php

declare(strict_types=1);

namespace App\Form\Question;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class AnswerForm extends AbstractType
{
    public const ADD_NEXT_ANSWER_FIELD = 'add_next_answer';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addAnswer($builder);

        $builder->add('save', SubmitType::class);
    }

    protected function addAnswer(FormBuilderInterface $builder): void
    {
        $builder->add(self::ADD_NEXT_ANSWER_FIELD, TextareaType::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Form\Question;

use App\FormType\QuillType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class QuestionForm extends AbstractType
{
    public const QUESTION_FIELD = 'question';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::QUESTION_FIELD,
            QuillType::class,
        );

        $builder->add(
            'zapisz',
            SubmitType::class, [
                'attr' => [
                    'class' => 'btn-primary btn w-100'
                ]
            ]
        );
    }
}

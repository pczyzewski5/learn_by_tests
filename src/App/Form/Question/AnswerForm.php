<?php

declare(strict_types=1);

namespace App\Form\Question;

use App\FormType\QuillType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class AnswerForm extends AbstractType
{
    public const ANSWER_FIELD = 'answer';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::ANSWER_FIELD,
            QuillType::class,
        );

        $builder->add('zapisz', SubmitType::class);
    }
}

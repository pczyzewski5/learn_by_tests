<?php

declare(strict_types=1);

namespace App\Form\Question;

use LearnByTests\Domain\Answer\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class ValidAnswerForm extends AbstractType
{
    public const VALID_ANSWER = 'valid_answer';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addValidAnswer($builder, $options['data']);

        $builder->add('save', SubmitType::class, ['disabled' => true]);
    }

    protected function addValidAnswer(FormBuilderInterface $builder, array $answers): void
    {
        $choices = [];

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $choices[$answer->getId()] = $answer->getId();
        }

        $builder->add(
            self::VALID_ANSWER,
            ChoiceType::class,
            [
                'choices' => $choices,
                'required' => true
            ]
        );
    }
}

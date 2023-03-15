<?php

declare(strict_types=1);

namespace App\Form\Question;

use LearnByTests\Domain\Answer\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CorrectAnswerForm extends AbstractType
{
    public const IS_CORRECT_ANSWER_FIELD = 'is_correct_answer_field';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('zapisz', SubmitType::class, [
            'disabled' => true,
            'attr' => [
                'class' => 'mt-2 btn-primary btn w-100'
            ]
        ]);

        $this->addIsCorrectAnswer($builder, $options['data']);
    }

    protected function addIsCorrectAnswer(FormBuilderInterface $builder, array $answers): void
    {
        $choices = [];

        /** @var Answer $answer */
        foreach ($answers as $answer) {
            $choices[$answer->getId()] = $answer->getId();
        }

        $builder->add(
            self::IS_CORRECT_ANSWER_FIELD,
            ChoiceType::class,
            [
                'choices' => $choices,
                'required' => true,
                'attr' => [
                    'hidden' => true,
                ],
                'label_attr' => [
                    'hidden' => true
                ],
                'label' => false
            ]
        );
    }
}

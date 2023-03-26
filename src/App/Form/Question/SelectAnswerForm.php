<?php

declare(strict_types=1);

namespace App\Form\Question;

use LearnByTests\Domain\Answer\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SelectAnswerForm extends AbstractType
{
    public const SELECTED_ANSWER_FIELD = 'selected_answer';
    public const ANSWERS_ORDER_FIELD = 'answers_order';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('submit', SubmitType::class, [
            'disabled' => true,
            'attr' => [
                'class' => 'mt-2 btn-primary btn w-100'
            ],
            'label' => 'Zapisz'
        ]);

        $this->addAnswers($builder, $options);
        $this->addAnswersOrder($builder, $options);
    }

    protected function addAnswers(FormBuilderInterface $builder, array $options): void
    {
        $choices = [];

        /** @var Answer $answer */
        foreach ($options['data'] as $answer) {
            $choices[$answer->getId()] = $answer->getId();
        }

        $builder->add(
            self::SELECTED_ANSWER_FIELD,
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

    protected function addAnswersOrder(FormBuilderInterface $builder, array $options): void
    {
        $data = [];

        /** @var Answer $answer */
        foreach ($options['data'] as $answer) {
            $data[] = $answer->getId();
        }

        $builder->add(
            self::ANSWERS_ORDER_FIELD,
            HiddenType::class,
            ['data' => \json_encode($data)]
        );
    }
}

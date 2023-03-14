<?php

declare(strict_types=1);

namespace App\Form\Question;

use LearnByTests\Domain\Category\CategoryEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryForm extends AbstractType
{
    public const CATEGORY_FIELD = 'category';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('zapisz', SubmitType::class,
            [
                'disabled' => true,
                'attr' => ['class' => 'w-100 btn-primary']
            ]
        );

        $this->addSelectCategory($builder);
    }

    protected function addSelectCategory(FormBuilderInterface $builder): void
    {
        $choices = \array_combine(
            CategoryEnum::toArray(),
            CategoryEnum::toArray()
        );

        $builder->add(
            self::CATEGORY_FIELD,
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
                'label' => false,
            ]
        );
    }
}

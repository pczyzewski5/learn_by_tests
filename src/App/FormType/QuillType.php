<?php

declare(strict_types=1);

namespace App\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuillType extends AbstractType
{
    private const BLOCK_PREFIX = 'quill_type';

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'compound' => false,
            'required' => false
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addModelTransformer(
            new CallbackTransformer(
                function ($data) use ($builder) {
//                    var_dump($data);exit;
                    return $data;
                },
                function ($data) use ($builder) {
//                    var_dump($data);exit;
                    return $data;
                }
            )
        );

        $builder->addViewTransformer(
            new CallbackTransformer(
                function ($data) use ($builder) {
                    return $data;
                },
                function ($data) use ($builder) {
                    return $data;
                }
            )
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['parent_name'] = $form->getParent()->getName();
    }

    public function getBlockPrefix()
    {
        return self::BLOCK_PREFIX;
    }
}

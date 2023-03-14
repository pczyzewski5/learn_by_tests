<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterUserForm extends AbstractType
{
    public const EMAIL_FIELD = 'email';
    public const PASSWORD_FIELD = 'password';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            self::EMAIL_FIELD,
            EmailType::class,
        );

        $builder->add(
            self::PASSWORD_FIELD,
            PasswordType::class,
            ['label' => 'Hasło']
        );

        $builder->add(
            'zapisz',
            SubmitType::class
        );
    }
}

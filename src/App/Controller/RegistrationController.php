<?php

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\Form\RegisterUserForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\RegisterUser;
use LearnByTests\Domain\User\Exception\UserAlreadyExistsException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function register(Request $request): Response
    {
        $form = $this->createForm(RegisterUserForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $this->commandBus->handle(
                    new RegisterUser(
                        $data[RegisterUserForm::EMAIL_FIELD],
                        'ROLE_USER',
                        $data[RegisterUserForm::PASSWORD_FIELD],
                        false
                    )
                );
            } catch (UserAlreadyExistsException $e) {
                return $this->renderForm('registration/register.html.twig', [
                    'register_form' => $form,
                    'error_message' => 'Account already exists.'
                ]);
            }

            return $this->redirectToRoute('register_info');
        }

        return $this->renderForm('registration/register.html.twig', [
            'register_form' => $form
        ]);
    }

    public function registerInfo()
    {
        return $this->renderForm('registration/register_info.html.twig');
    }
}

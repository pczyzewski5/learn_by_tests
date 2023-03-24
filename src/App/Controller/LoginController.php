<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends BaseController
{
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        if (null === $user) {
            return $this->render('login/login.html.twig', [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error' => $authenticationUtils->getLastAuthenticationError()
            ]);
        }

        if ($this->isGranted('ROLE_SUPER_ADMIN')
            || $this->isGranted('ROLE_ADMIN')
        ) {
            return $this->redirectToRoute('category_list');
        }

        return $this->redirectToRoute('user_category_list');
    }
}

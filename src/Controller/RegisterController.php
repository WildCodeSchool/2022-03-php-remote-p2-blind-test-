<?php

namespace App\Controller;

class RegisterController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('/login/register.html.twig');
    }
}

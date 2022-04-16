<?php

namespace  App\Controller;

class QuizzController extends AbstractController
{
    public function index()
    {
        return $this->twig->render('Quizz/index.html.twig');
    }
}

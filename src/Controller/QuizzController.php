<?php

namespace  App\Controller;

use App\Model\QuizzManager;
use App\Model\UserManager;

class QuizzController extends AbstractController
{
    public function index()
    {
        $categoryManager = new QuizzManager();
        $userManager = new UserManager();
        $users = $userManager->selectAll();
        $categories = $categoryManager->selectAll();
        return $this->twig->render('Quizz/index.html.twig', [
            'categories' => $categories,
            'users' => $users
        ]);
    }
}

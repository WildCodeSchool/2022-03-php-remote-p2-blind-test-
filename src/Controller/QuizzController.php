<?php

namespace  App\Controller;

use App\Model\CategoryManager;

class QuizzController extends AbstractController
{
    public function index()
    {
        $categoryManager = new CategoryManager();

        $categories = $categoryManager->selectAll();
        return $this->twig->render('Quizz/index.html.twig', [
            'categories' => $categories
        ]);
    }

    public function category($id)
    {
        $categoryManager = new CategoryManager();

        $categories = $categoryManager->selectOneById($id);
        return $this->twig->render('Quizz/index.html.twig', [
            'categories' => $categories
        ]);
    }

    public function progess()
    {
        return $this->twig->render('Quizz/quizzProgress.html.twig');
    }
}

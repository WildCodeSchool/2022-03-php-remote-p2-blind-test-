<?php

namespace  App\Controller;

use App\Model\QuizzManager;

class GameController extends AbstractController
{
    public function index()
    {
        $categoryManager = new QuizzManager();

        $categories = $categoryManager->selectAll();
        return $this->twig->render('Game/index.html.twig', [
            'categories' => $categories
        ]);
    }

    public function category($id)
    {
        $categoryManager = new QuizzManager();

        $categories = $categoryManager->selectOneById($id);
        return $this->twig->render('Game/index.html.twig', [
            'categories' => $categories
        ]);
    }
}

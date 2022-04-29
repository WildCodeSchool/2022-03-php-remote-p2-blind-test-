<?php

namespace  App\Controller;

use App\Model\CategoryManager;
use App\Model\UserManager;

class CategoryController extends AbstractController
{
    public function index()
    {
        $categoryManager = new CategoryManager();
        /* $userManager = new UserManager(); */
        /* $users = $userManager->selectAll(); */
        $categories = $categoryManager->selectAll();
        return $this->twig->render('Category/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}

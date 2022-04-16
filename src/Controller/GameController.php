<?php

namespace  App\Controller;

class GameController extends AbstractController
{
    public function index()
    {

        $categories = ['Rap', 'Meme'];
        return $this->twig->render('Game/index.html.twig', [
            'categories' => $categories
        ]);
    }
}

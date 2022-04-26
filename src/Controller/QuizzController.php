<?php

namespace  App\Controller;

use App\Model\CategoryManager;
use App\Model\TrackManager;

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
        $trackManager = new TrackManager();

        $tracks = $trackManager->selectPathRand($id);
        $categories = $categoryManager->selectOneById($id);

        return $this->twig->render('Quizz/index.html.twig', [
            'categories' => $categories,
            'tracks' => $tracks
        ]);
    }

    public function progess($id)
    {
        if(empty($_POST)){
            $trackManager = new TrackManager();

            $_SESSION['tracks'] = $trackManager->selectPathRand($id);

        }elseif(isset($_POST['validate']) || isset($_POST['pass'])){
            $_SESSION['recup'] = array_shift($_SESSION['tracks']);
            var_dump($_SESSION['recup']);
            if(empty($_SESSION['tracks'])){
                echo 'vide';
            }
        }


        return $this->twig->render('Quizz/progress.html.twig', [
            'tracks' => $_SESSION['tracks']
        ]);
    }
}

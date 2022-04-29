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
        if (empty($_POST)) {
            $trackManager = new TrackManager();
            $_SESSION['tracks'] = $trackManager->selectPathRand($id);
            $_SESSION['replay'] = [];
        }

        if (isset($_POST['pass']) && !empty($_SESSION['tracks'])) {
                array_unshift($_SESSION['replay'], array_shift($_SESSION['tracks']));
        }

        if (isset($_POST['validate']) && !empty($_SESSION['tracks'])) {
                $_SESSION['validate'] = array_shift($_SESSION['tracks']);
        }

        if (empty($_SESSION['tracks'])) {
            $_SESSION['tracks'] = $_SESSION['replay'];
            $_SESSION['replay'] = [];
        }

        return $this->twig->render('Quizz/progress.html.twig', [
            'tracks' => $_SESSION['tracks']
        ]);
    }
}

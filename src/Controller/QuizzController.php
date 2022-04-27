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
        // unset($_SESSION['recup']);
        if (empty($_POST)) {
            $trackManager = new TrackManager();
            $_SESSION['tracks'] = $trackManager->selectPathRand($id);
            $_SESSION['recup'] = [];
        } elseif (isset($_POST['pass'])) {
            if (!empty($_SESSION['tracks'])) {
                array_unshift($_SESSION['recup'], array_shift($_SESSION['tracks']));
                var_dump($_SESSION['tracks']);
            } else {
                $_SESSION['tracks'] = $_SESSION['recup'];
            }
        } elseif (isset($_POST['validate'])) {
            if (!empty($_SESSION['tracks'])) {
                // $validate = array_shift($_SESSION['tracks']);
                var_dump($_SESSION['tracks']);
            } else {
                $_SESSION['tracks'] = $_SESSION['recup'];
            }
        }
        return $this->twig->render('Quizz/progress.html.twig', [
            'tracks' => $_SESSION['tracks']
        ]);
    }
}

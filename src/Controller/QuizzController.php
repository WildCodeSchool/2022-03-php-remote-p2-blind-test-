<?php

namespace  App\Controller;

use App\Model\QuizzManager;
use App\Model\TrackManager;
use App\Service\QuizzSession;
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
        $trackManager = new TrackManager();

        $tracks = $trackManager->selectPathRand($id);
        $categories = $categoryManager->selectOneById($id);

        return $this->twig->render('Quizz/index.html.twig', [
            'categories' => $categories,
            'tracks' => $tracks
        ]);
    }

    public function start(int $categoryId, int $level)
    {
        $_SESSION['level'] = $level;
        $quizzManager = new QuizzManager();
        $quizzSession = $quizzManager->insert();
        $_SESSION['quizz_session'] = $quizzManager->selectSessionById($quizzSession);
        $trackManager = new TrackManager();
        $_SESSION['quizz_session']->setTracks($trackManager->selectPathRand($categoryId));
        header("Location: /quizz/progress?id=" . $categoryId);
    }

    public function progess()
    {
        if (
            isset($_SESSION['quizz_session'])
            && $_SESSION['quizz_session'] instanceof QuizzSession
            && $_SESSION['quizz_session']->isActive()
        ) {
            if ($_SESSION['level'] == 1) {
                $_SESSION['quizz_session']->levelEasy();
                unset($_POST['validate']);
            } else {
                $_SESSION['quizz_session']->levelHard();
            }
            return $this->twig->render('Quizz/progress.html.twig', [
                'tracks' => $_SESSION['quizz_session']->getTracks(),
                'displayAnswer' => $_SESSION['quizz_session']->getDisplayAnswer(),
            ]);
        } else {
            return $this->twig->render('Home/index.html.twig');
        }
    }
}

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

    public function start(int $categoryId)
    {
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
            if (isset($_POST['pass']) && !empty($_SESSION['quizz_session']->getTracks())) {
                $_SESSION['quizz_session']->trackMoveToReplay();
            }

            if (isset($_POST['validate']) && !empty($_SESSION['quizz_session']->getTracks())) {
                $_SESSION['quizz_session']->answerCheck($_POST['answer']);
            }

            if (empty($_SESSION['quizz_session']->getTracks())) {
                $_SESSION['quizz_session']->setTracks($_SESSION['quizz_session']->getReplay());
                $_SESSION['quizz_session']->emptyTheArrayReplay();
            }
            return $this->twig->render('Quizz/progress.html.twig', [
                'tracks' => $_SESSION['quizz_session']->getTracks()
            ]);
        } else {
            return $this->twig->render('Home/index.html.twig');
        }
    }
}

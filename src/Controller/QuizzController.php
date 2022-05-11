<?php

namespace  App\Controller;

use App\Model\QuizzManager;
use App\Model\TrackManager;
use App\Service\QuizzSession;
use App\Model\CategoryManager;
use App\Model\UserManager;
use App\Service\User;

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

        if (empty($_SESSION['user']->getId())) {
            $quizzSession = $quizzManager->insertUniq();
            $_SESSION['quizz_session'] = $quizzManager->selectSessionById($quizzSession);
        } else {
            $quizzSession = $quizzManager->insert($_SESSION['user']->getId());
            $_SESSION['quizz_session'] = $quizzManager->selectSessionById($quizzSession);
        }
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
            } else {
                $_SESSION['quizz_session']->levelHard();
            }
            return $this->twig->render('Quizz/progress.html.twig', [
                'tracks' => $_SESSION['quizz_session']->getTracks()
            ]);
        } else {
            return $this->twig->render('/Quizz/result.html.twig');
        }
    }

    public function result()
    {
        if (isset($_SESSION['quizz_session'])) {
            $id = $_SESSION['quizz_session']->getId();
            $score = count($_SESSION['quizz_session']->getCorrect());
            $quizzManager = new QuizzManager();
            $quizzManager->insertScore($score, $id);
            $ranks = $quizzManager->selectAll('score');
            return $this->twig->render('/Quizz/result.html.twig', [
                'ranks' => $ranks
            ]);
        } else {
            $quizzManager = new QuizzManager();
            $ranks = $quizzManager->selectAll('score');
            return $this->twig->render('/Quizz/result.html.twig', [
                'ranks' => $ranks
            ]);
        }
    }
    public function lastSeven()
    {
        $quizzManager = new QuizzManager();
        $ranks = $quizzManager->selectLastSeven('score');
        return $this->twig->render('/Quizz/result.html.twig', [
            'ranks' => $ranks
        ]);
    }

    public function pass()
    {
        setcookie('endedAt', "", time());
        unset($_COOKIE['endedAt']);
        header("Location: /quizz/result");
    }
}

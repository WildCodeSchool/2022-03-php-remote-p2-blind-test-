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
        $user = $_SESSION['user']->getNickname();
        $_SESSION['level'] = $level;
        $quizzManager = new QuizzManager();
        $userManager = new UserManager();
        $userId =  $userManager->selectOneByNickname($user);
        $id = $userId->getID();
        $quizzSession = $quizzManager->insert($id, $categoryId);
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
            return $this->twig->render('/Quizz/result.html.twig');
        }
    }

    public function result()
    {
        $categoryManager = new CategoryManager();
        $categorises = $categoryManager->selectAll();

        if (isset($_SESSION['quizz_session'])) {
            $id = $_SESSION['quizz_session']->getId();
            $score = count($_SESSION['quizz_session']->getCorrect());
            $quizzManager = new QuizzManager();
            $quizzManager->insertScore($score, $id);
            $ranks = $quizzManager->selectAll('score');
            $results = $_SESSION['quizz_session'];
            unset($_SESSION['quizz_session']);
            return $this->twig->render('/Quizz/result.html.twig', [
                'ranks' => $ranks,
                'categorises' => $categorises,
                'results' => $results
            ]);
        } else {
            $quizzManager = new QuizzManager();
            $ranks = $quizzManager->selectAll('score');
            return $this->twig->render('/Quizz/result.html.twig', [
                'ranks' => $ranks,
                'categorises' => $categorises
            ]);
        }
    }

    public function categoryResult()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoryManager = new CategoryManager();
            $categorises = $categoryManager->selectAll();

            $quizzManager = new QuizzManager();
            $ranks = $quizzManager->selectAllByCategory($_POST['categories']);

            return $this->twig->render('/Quizz/result.html.twig', [
                'ranks' => $ranks,
                'categorises' => $categorises
            ]);
        }
    }
}

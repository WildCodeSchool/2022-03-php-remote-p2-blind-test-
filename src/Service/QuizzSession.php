<?php

namespace App\Service;

use DateTime;
use App\Model\AnswerManager;

class QuizzSession
{
    private int $id;
    private string $startedAt;
    private string $endedAt;
    private string $displayAnswer;
    private array $tracks = [];
    private array $replay = [];
    private array $correct = [];
    private array $incorrect = [];
    private array $qcmAnswers = [];

    /**
     * Création du cookie à l'instanciation de la classe
     */
    public function __construct()
    {
        $this->setCookie();
    }

    /**
     * La méthode qui crée le cookie
     */
    public function setCookie(): void
    {
        setcookie('endedAt', strval($this->getEndedAt()->getTimestamp()), [
            'expires' => strtotime('+30 days'),
            'path' => '/'
        ]);
    }

    ////////////////////////////// Les guetteurs et setteurs //////////////////////////////
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getStartedAt(): DateTime
    {
        return new DateTime($this->startedAt);
    }

    /**
     * @param string $startedAt
     */
    public function setStartedAt(string $startedAt): void
    {
        $this->startedAt = $startedAt;
    }

    /**
     * @return DateTime
     */
    public function getEndedAt(): DateTime
    {
        return new DateTime($this->endedAt);
    }

    /**
     * @param string $endedAt
     */
    public function setEndedAt(string $endedAt): void
    {
        $this->endedAt = $endedAt;
    }

    public function getTracks(): array
    {
        return $this->tracks;
    }

    public function setTracks($tracks): void
    {
        $this->tracks = $tracks;
    }

    public function getReplay(): array
    {
        return $this->replay;
    }

    public function setReplay($replay): void
    {
        $this->tracks = $replay;
    }

    public function getCorrect(): array
    {
        return $this->correct;
    }

    public function setCorrect($correct): void
    {
        $this->correct = $correct;
    }

    public function getIncorrect(): array
    {
        return $this->incorrect;
    }

    public function setIncorrect($incorrect): void
    {
        $this->incorrect = $incorrect;
    }

    public function getQcmAnswers(): array
    {
        return $this->qcmAnswers;
    }

    public function setQcmAnswers($qcmAnswers): void
    {
        $this->qcmAnswers = $qcmAnswers;
    }

    public function getDisplayAnswer(): string|bool
    {
        return !empty($this->displayAnswer) ?  $this->displayAnswer : false ;
    }

    public function setDisplayAnswer($displayAnswer): void
    {
        $this->displayAnswer = $displayAnswer;
    }

    ///////////////////////////////// Méthode logique //////////////////////////////////////////////

    /**
     * Vérifie si la session et toujours active
     */
    public function isActive(): bool
    {
        $currentTime = new DateTime();
        return $this->getEndedAt()->getTimestamp() - $currentTime->getTimestamp() > 0;
    }

    /**
     * Vérifie la réponse du joueur en acceptant
     * un certain niveau de faute d'orthographe
     */
    public function answerCheck(string $userAnswer): void
    {
        if (!empty($userAnswer)) {
            // On récupère et on enlève la piste
            $tracks = $this->getTracks();
            $track = array_shift($tracks);

            // On récupère et on compare la réponse du joueur avec celle de la table [answer]
            $answerManager = new AnswerManager();
            $answer = $answerManager->selectOneByIdAndTitle($track['id'], $userAnswer);

            // On teste le retour de la table, et on ajoute la piste
            // ainsi que la réponse au tableau [correct] ou [incorrect] en fonction du retour
            if ($answer) {
                $validate = [$track, $userAnswer];
                array_unshift($this->correct, $validate);
                $this->setDisplayAnswer($track['title'] . "✅");
            } else {
                $validate = [$track, $userAnswer];
                array_unshift($this->incorrect, $validate);
                $this->setDisplayAnswer($track['title'] . "❌");
            }
            // Et on réinitialise le tableau [track]
            $this->setTracks($tracks);
        }
    }

    /**
     * Génère un tableau de réponse pour le level Easy (QCM)
     */
    public function generateAnswerTable(): void
    {
        // On récupère les réponses qui ne sont pas égales au nom de la piste
        $answerManager = new AnswerManager();
        $answers = $answerManager->selectByTitle($this->getTracks()[0]['title']);

        // On boucle sur chaque élément pour lui enlever sa clé, que l'on met dans un tableau vide
        $qcmAnswers = [];
        foreach ($answers as $answer) {
            $qcmAnswers[] = $answer['title'];
        }

        // Récupération des trois premiers
        $this->setQcmAnswers(array_slice($qcmAnswers, 0, 3));

        // Ajout de la bonne réponse au tableau
        array_unshift($this->qcmAnswers, $this->getTracks()[0]['title']);

        // Et on mélange le tout
        shuffle($this->qcmAnswers);
    }

    /**
     * Si le bouton ['pass'] et cliquez, retire la piste qui vient
     * d'être joué et la place dans le tableau [replay]
     */
    public function trackMoveToReplay(): void
    {
        if (isset($_POST['pass']) && !empty($this->getTracks())) {
            $tracks = $this->getTracks();
            array_unshift($this->replay, array_shift($tracks));
            $this->setTracks($tracks);
        }
    }

    /**
     * Recharge le tableau [Tracks] avec le tableau [Replay] et vide celui-ci
     */
    private function reloadingTrackTable(): void
    {
        if (empty($this->getTracks())) {
            $this->setTracks($this->getReplay());
            $this->replay = [];
        }
    }

    /**
     * Logique du level Hard
     */
    public function levelHard(): void
    {
        $this->trackMoveToReplay();
        $this->reloadingTrackTable();

        if (isset($_POST['validate']) && !empty($this->getTracks())) {
            $this->answerCheck($_POST['answer']);
        }
    }

    /**
     * Logique du level Easy
     */
    public function levelEasy(): void
    {
        $this->trackMoveToReplay();
        $this->reloadingTrackTable();

        if (isset($_POST['validate']) && !empty($this->getTracks())) {
            $this->answerCheck($_POST['validate']);
        }
        if (!empty($this->getTracks())) {
            $this->generateAnswerTable();
        }
    }
}

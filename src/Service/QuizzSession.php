<?php

namespace App\Service;

use DateTime;
use App\Model\AnswerManager;

class QuizzSession
{
    private int $id;
    private string $startedAt;
    private string $endedAt;
    private array $tracks = [];
    private array $replay = [];
    private array $correct = [];
    private array $incorrect = [];

    // Création du cookie à l'instanciation de la classe
    public function __construct()
    {
        $this->setCookie();
    }

    // La méthode qui crée le cookie
    public function setCookie(): void
    {
        setcookie('endedAt', strval($this->getEndedAt()->getTimestamp()), [
            'expires' => strtotime('+30 days'),
            'path' => '/'
        ]);
    }


    // Les guetteurs et setteurs
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

    // Vérifie si la session et toujours active
    public function isActive()
    {
        $currentTime = new DateTime();
        return $this->getEndedAt()->getTimestamp() - $currentTime->getTimestamp() > 0;
    }

    // Retire la piste qui vient d'être joué et la place dans le tableau [replay]
    public function trackMoveToReplay(): void
    {
        $tracks = $this->getTracks();
        array_unshift($this->replay, array_shift($tracks));
        $this->setTracks($tracks);
    }

    // Vide le tableau [replay]
    public function emptyTheArrayReplay(): void
    {
        $this->replay = [];
    }

    // Vérifie la réponse du joueur en acceptant un certain niveau de faute d'orthographe
    public function answerCheck(string $userAnswer): void
    {
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
        } else {
            $validate = [$track, $userAnswer];
            array_unshift($this->incorrect, $validate);
        }
        // Et on réinitialise le tableau [track]
        $this->setTracks($tracks);
    }
}

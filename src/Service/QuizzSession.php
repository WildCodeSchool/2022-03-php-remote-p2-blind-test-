<?php

namespace App\Service;

use DateTime;

class QuizzSession
{
    private int $id;
    private string $startedAt;
    private string $endedAt;
    private array $tracks = [];
    private array $replay = [];
    private array $validate = [];

    public function __construct()
    {
        $this->setCookie();
    }

    public function setCookie(): void
    {
        setcookie('endedAt', strval($this->getEndedAt()->getTimestamp()), [
            'expires' => strtotime('+30 days'),
            'path' => '/'
        ]);
    }

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

    public function isActive()
    {
        $currentTime = new DateTime();
        return $this->getEndedAt()->getTimestamp() - $currentTime->getTimestamp() > 0;
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

    public function getValidate(): array
    {
        return $this->validate;
    }

    public function setValidate($validate): void
    {
        $this->validate = $validate;
    }

    public function trackMoveToReplay(): void
    {
        $tracks = $this->getTracks();
        array_unshift($this->replay, array_shift($tracks));
        $this->setTracks($tracks);
    }

    public function moveToValidate(): void
    {
        $tracks = $this->getTracks();
        array_unshift($this->validate, array_shift($tracks));
        $this->setTracks($tracks);
    }

    public function emptyTheArrayReplay(): void
    {
        $this->replay = [];
    }
}

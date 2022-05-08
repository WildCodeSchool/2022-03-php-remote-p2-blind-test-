<?php

namespace App\Model;

use PDO;
use App\Service\QuizzSession;

class QuizzManager extends AbstractManager
{
    public const TABLE = 'quizz_session';

    public function insert(int $id)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`startedAt`, `endedAT`, `user_id`) VALUES
         (NOW(), DATE_ADD(NOW(), INTERVAL 1 MINUTE), :id)");
        // $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    public function insertScore(int $score, int $id)
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
            " SET `score`=:score WHERE id=:id");
        // $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':score', $score, PDO::PARAM_INT);
        $statement->bindValue('id', $id, PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    public function selectSessionById(int $id): QuizzSession|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchObject(QuizzSession::class);
    }
}

<?php

namespace App\Model;

use PDO;
use App\Service\QuizzSession;

class QuizzManager extends AbstractManager
{
    public const TABLE = 'quizz_session';

    public function insert()
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`startedAt`, `endedAT`) VALUES
         (NOW(), DATE_ADD(NOW(), INTERVAL 1 MINUTE))");
        // $statement->bindValue(':user', $user, PDO::PARAM_STR);
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

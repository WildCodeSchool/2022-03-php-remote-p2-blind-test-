<?php

namespace App\Model;

class AnswerManager extends AbstractManager
{
    public const TABLE = 'answer';

    public function selectOneByIdAndTitle(int $id, string $userAnswer): array|false
    {
        $statement = $this->pdo->prepare("SELECT title FROM " . self::TABLE .
        " WHERE track_id=:id AND SOUNDEX(title) = SOUNDEX(:userAnswer)");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->bindValue(':userAnswer', $userAnswer, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function selectByTitle(string $title): array
    {
        $statement = $this->pdo->prepare("SELECT title FROM " . self::TABLE .
        " WHERE title != :title ORDER BY RAND()");
        $statement->bindValue(':title', $title, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetchAll();
    }
}

<?php

namespace App\Model;

use PDO;
use App\Service\QuizzSession;

class QuizzManager extends AbstractManager
{
    public const TABLE = 'quizz_session';

    public function insert(int $id, int $categoryId)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`startedAt`, `endedAT`, `user_id`, `category_id`) VALUES
         (NOW(), DATE_ADD(NOW(), INTERVAL 1 MINUTE), :id, :category_id)");
        // $statement->bindValue(':user', $user, PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
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

    public function selectAll(string $orderBy = '', string $direction = 'DESC'): array
    {
        $query = 'SELECT q.score, u.nickname as pseudo, u.image  FROM ' . static::TABLE .
            ' q JOIN user u ON u.id = q.user_id';
        if ($orderBy) {
            $query .= ' ORDER BY  ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    public function selectAllByCategory(int $categoryId): array
    {
        $statement = $this->pdo->prepare('SELECT q.score, u.nickname as pseudo, u.image  FROM ' . self::TABLE .
        ' q JOIN user u ON u.id = q.user_id WHERE q.category_id=:category_id ORDER BY q.score DESC');
        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}

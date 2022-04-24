<?php

namespace App\Model;

class TrackManager extends AbstractManager
{
    public const TABLE = 'track';

    public function selectAllRand(int $id): array|false
    {
        $statement = $this->pdo->prepare("SELECT path FROM " . static::TABLE .
            " WHERE category_id=:id ORDER BY RAND()");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}

<?php

namespace App\Model;

class DashboardManager extends AbstractManager
{
    public const TABLE = 'track';

        /**
     * Insert new instrument in database
     */

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT t.*, c.name  FROM ' . static::TABLE . ' as t JOIN category as c ON c.id = t.category_id';
        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }

        return $this->pdo->query($query)->fetchAll();
    }

    public function insert(array $dashboard): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`title`,`artist`, `path`, `category_id`)
        VALUES (:title,:artist, :path, :category_id)");

        $statement->bindValue(':title', $dashboard['title'], \PDO::PARAM_STR);
        $statement->bindValue(':artist', $dashboard['artist'], \PDO::PARAM_STR);
        $statement->bindValue(':path', $dashboard['path'], \PDO::PARAM_STR);
        $statement->bindValue(':category_id', $dashboard['category'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}

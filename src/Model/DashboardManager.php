<?php

namespace App\Model;

class DashboardManager extends AbstractManager
{
    public const TABLE = 'track';

        /**
     * Insert new instrument in database
     */
    public function insert(array $dashboard): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`title`,`artiste`,`date`, `path`, `category_id`)
        VALUES (:title,:artiste, :date, :path, :category_id)");

        $statement->bindValue('title', $dashboard['title'], \PDO::PARAM_STR);
        $statement->bindValue('artiste', $dashboard['artiste'], \PDO::PARAM_STR);
        $statement->bindValue('date', $dashboard['date'], \PDO::PARAM_INT);
        $statement->bindValue('path', $dashboard['path'], \PDO::PARAM_STR);
        $statement->bindValue('category_id', $dashboard['category_id'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}

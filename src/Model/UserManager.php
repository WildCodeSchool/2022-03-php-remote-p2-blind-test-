<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function insert($user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
            " (`email`, `password`, `nickname`)
        VALUES ('default', 'default', :user)");

        $statement->bindValue(':user', $user, \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function selectOneByNickname(string $nickname): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT id FROM " . static::TABLE . " WHERE nickname=:nickname");
        $statement->bindValue(':nickname', $nickname, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(\PDO::FETCH_NUM);
    }
}

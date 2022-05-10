<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function add($user): int
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
    public function selectByEmail($email): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue('email', $email, \PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch();
    }

    public function insert(array $credentials): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE .
            " (email, password, nickname)
        VALUES (:email, :password, :nickname)");
        $statement->bindValue(':email', $credentials['email']);
        $statement->bindValue(':password', password_hash($credentials['password'], PASSWORD_DEFAULT));
        $statement->bindValue(':nickname', $credentials['nickname']);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}

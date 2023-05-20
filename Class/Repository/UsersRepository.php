<?php

namespace Repository;

use DB\MySQL;

class UsersRepository
{

    private object $MySQL;
    const TABLE = 'users';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function getMySQL(): object
    {
        return $this->MySQL;
    }

    public function updateUser($id, $body)
    {
        [$login, $password] = [$body['login'], $body['password']];

        $queryPut = 'UPDATE ' . SELF::TABLE . ' SET login = :login, password :password where id = :id';

        $this->MySQL->beginTransaction();

        $stmt = $this->MySQL->prepare($queryPut);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();
    }
}
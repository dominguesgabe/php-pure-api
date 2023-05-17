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
}
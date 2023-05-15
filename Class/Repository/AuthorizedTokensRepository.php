<?php

namespace Repository;

use DB\MySQL;

class AuthorizedTokensRepository
{
    private object $MySQL;
    private const TABLE = "authorized_tokens";

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function validateToken($token)
    {

    }

    public function getMySQL()
    {
        return $this->MySQL;
    }
}
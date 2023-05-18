<?php

namespace Repository;

use DB\MySQL;
use Util\GenericConstsUtil;

class AuthorizedTokensRepository
{
    private object $MySQL;
    private const TABLE = "authorized_tokens";

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    public function validateToken(string $token)
    {
        $treatedToken = str_replace([' ', 'Bearer'], '', $token);

        if (!$treatedToken) {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_EMPTY_TOKEN);
        }

        $query = 'SELECT id FROM ' . self::TABLE . ' WHERE token = :token AND status = :status';

        $statement = $this->getMySQL()->getDb()->prepare($query);
        $statement->bindValue(':token', $treatedToken);
        $statement->bindValue(':status', GenericConstsUtil::YES);

        $statement->execute();

        if ($statement->rowCount() !== 1) {
            header('HTTP/1.1 401 Unauthorized');
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_UNAUTHORIZED_TOKEN);
        }
    }

    public function getMySQL(): object
    {
        return $this->MySQL;
    }
}
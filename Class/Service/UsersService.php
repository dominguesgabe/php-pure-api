<?php

namespace Service;

use Kint\Kint;
use Repository\UsersRepository;
use Util\GenericConstsUtil;

class UsersService
{
    const TABLE = 'users';
    const RESOURCES_GET = ['list'];
    const RESOURCES_DELETE = ['delete'];
    private array $data;
    private object $UsersRepository;
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->UsersRepository = new UsersRepository();
    }

    public function validateGet()
    {
        $resource = $this->data['resource'];

        if (!in_array($resource, SELF::RESOURCES_GET, true)) {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NON_EXISTENT_RESOURCE);
        }

        $return = $this->data['id'] > 0 ? $this->getUserById() : $this->$resource();

        if (!$return) {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_GENERIC);
        }

        return $return;
    }

    public function validateDelete()
    {
        if (!in_array($this->data['resource'], SELF::RESOURCES_DELETE, true)) {
            return utf8_encode(GenericConstsUtil::MSG_ERROR_TYPE_ROUTE);
        }

        if (!$this->data['id']) {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_REQUIRED_ID);
        }

        return $this->UsersRepository->getMySQL()->delete(SELF::TABLE, $this->data['id']);
    }

    private function getUserById()
    {
        return $this->UsersRepository->getMySQL()->getOneByKey(SELF::TABLE, $this->data['id']);
    }

    private function list()
    {
        return $this->UsersRepository->getMySQL()->getAll(SELF::TABLE);
    }
}
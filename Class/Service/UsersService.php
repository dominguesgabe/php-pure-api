<?php

namespace Service;

use Repository\UsersRepository;
use Util\GenericConstsUtil;

class UsersService
{
    const TABLE = 'users';
    const RESOURCES_GET = ['list'];
    private array $data;
    private object $UsersRepository;
    public function __construct($data = [])
    {
        $this->data = $data;
        $this->UsersRepository = new UsersRepository();
    }

    public function validateGet()
    {
        $return = null;

        $resource = $this->data['resource'];

        if (in_array($resource, SELF::RESOURCES_GET, true)) {
            $return = $this->data['id'] > 0 ? $this->getUserById() : $this->$resource();

            var_dump($return);exit;
        } else {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NON_EXISTENT_RESOURCE);
        }

        if (!$return) {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_GENERIC);
        }
    }

    private function getUserById()
    {

    }

    private function list()
    {
        return $this->UsersRepository->getMySQL()->getAll(SELF::TABLE);
    }
}
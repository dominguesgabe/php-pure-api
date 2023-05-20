<?php

namespace Service;

use http\Exception\InvalidArgumentException;
use Kint\Kint;
use Repository\UsersRepository;
use Util\GenericConstsUtil;

class UsersService
{
    const TABLE = 'users';
    const RESOURCES_GET = ['list'];
    const RESOURCES_POST = ['create'];
    const RESOURCES_PUT = ['update'];
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

    public function validatePost(array $requestBody)
    {
        if (!in_array($this->data['resource'], SELF::RESOURCES_POST, true)) {
            return utf8_encode(GenericConstsUtil::MSG_ERROR_TYPE_ROUTE);
        }

        if (!$requestBody['login'] || !$requestBody['password']) {
            http_response_code(GenericConstsUtil::BAD_REQUEST);
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_BAD_REQUEST);
        }

        if (!$this->UsersRepository->getMySQL()->post(SELF::TABLE, $requestBody)) {
            $this->UsersRepository->getMySQL()->getDb()->rollBack();
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NOT_AFFECTED);
        }

        $lastId = $this->UsersRepository->getMySQL()->getDb()->lastInsertId();
        $this->UsersRepository->getMySQL()->getDb()->commit();

        http_response_code(GenericConstsUtil::NO_CONTENT);
        return ['id' => $lastId];
    }

    public function validatePut(array $requestBody)
    {
        if (!in_array($this->data['resource'], SELF::RESOURCES_PUT, true)) {
            return utf8_encode(GenericConstsUtil::MSG_ERROR_TYPE_ROUTE);
        }

        if (!$requestBody['login'] || !$requestBody['password']) {
            http_response_code(GenericConstsUtil::BAD_REQUEST);
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_BAD_REQUEST);
        }

        if (!$this->data['id']) {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_REQUIRED_ID);
        }

        if ($this->UsersRepository->updateUser($this->data['id'], $requestBody)) {
            $this->UsersRepository->getMySQL()->getDb()->commit();
            return GenericConstsUtil::MSG_SUCCESS_UPDATED;
        }

        $this->UsersRepository->getMySQL()->getDb()->rollBack();
        throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NOT_AFFECTED);
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
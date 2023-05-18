<?php

namespace Validator;
use Repository\AuthorizedTokensRepository;
use Service\UsersService;
use Util\GenericConstsUtil;
use Util\JsonUtil;

class RequestValidator
{
    private $request;
    private array $requestData = [];
    private object $authorizedTokensRepository;

    const GET = "GET";
    const DELETE = "DELETE";
    const USERS = "USERS";


    public function __construct($request)
    {
        $this->request = $request;
        $this->authorizedTokensRepository = new AuthorizedTokensRepository();

    }

    public function processRequest()
    {
        if (!in_array($this->request['method'], GenericConstsUtil::REQUEST_TYPE, true)) {
            return utf8_encode(GenericConstsUtil::MSG_ERROR_TYPE_ROUTE);
        }

        return $this->directRequest();
    }

    private function directRequest()
    {
        if ($this->request['method'] !== self::GET && $this->request['method'] !== self::DELETE) {
            $jsonUtil = new JsonUtil();
            $this->requestData = $jsonUtil->treatJsonBody();
        }

        $token = getallheaders()['Authorization'];
        $this->authorizedTokensRepository->validateToken($token);

        $method = $this->request['method'];

        return $this->$method();
    }

    private function get()
    {

        if (!in_array($this->request['route'], GenericConstsUtil::TYPE_GET, true)) {
            return utf8_encode(GenericConstsUtil::MSG_ERROR_TYPE_ROUTE);
        }

        if ($this->request['route'] !== SELF::USERS) {
            throw new \InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NON_EXISTENT_RESOURCE);
        }

        $userService = new UsersService($this->request);
        return $userService->validateGet();
    }

    private function delete()
    {
        $userService = new UsersService($this->request);
        return $userService->validateDelete();
    }
}
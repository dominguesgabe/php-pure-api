<?php

namespace Validator;
use Repository\AuthorizedTokensRepository;
use Util\GenericConstsUtil;
use Util\JsonUtil;

class RequestValidator
{
    private $request;
    private array $requestData = [];
    private object $authorizedTokensRepository;

    const GET = "GET";
    const DELETE = "DELETE";

    public function __construct($request)
    {
        $this->request = $request;
        $this->authorizedTokensRepository = new AuthorizedTokensRepository();

    }

    public function processRequest()
    {
        if (!in_array($this->request['method'], GenericConstsUtil::REQUEST_TYPE, true)) {
            $return = utf8_encode(GenericConstsUtil::MSG_ERROR_TYPE_ROUTE);
        }

        $return = $this->directRequest();

        var_dump($return);

        return $return;
    }

    private function directRequest()
    {
        if ($this->request['method'] !== self::GET && $this->request['method'] !== self::DELETE) {
            $jsonUtil = new JsonUtil();
            $this->requestData = $jsonUtil->treatJsonBody();
        }
    }
}
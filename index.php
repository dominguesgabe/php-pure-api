<?php

use Util\GenericConstsUtil;
use Util\JsonUtil;
use Util\RoutesUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {

    $routesUtil = new RoutesUtil();

    $requestValidator = new RequestValidator($routesUtil->getRoutes());
    $response = $requestValidator->processRequest();

    $jsonUtil = new JsonUtil();
    $jsonUtil->proccessReturn($response);

} catch (Exception $e) {

    echo json_encode([
        GenericConstsUtil::TYPE => GenericConstsUtil::TYPE_ERROR,
        GenericConstsUtil::DATA => utf8_encode($e->getMessage())
    ]);

}

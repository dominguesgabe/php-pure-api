<?php

use Util\GenericConstsUtil;
use Util\RoutesUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {

    $routesUtil = new RoutesUtil();

    $requestValidator = new RequestValidator($routesUtil->getRoutes());
    $return = $requestValidator->processRequest();

} catch (Exception $e) {

    echo json_encode([
        GenericConstsUtil::TYPE => GenericConstsUtil::TYPE_ERROR,
        GenericConstsUtil::ANSWER => utf8_encode($e->getMessage())
    ]);

}

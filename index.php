<?php

use Util\RoutesUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {

    $routesUtil = new RoutesUtil();

    $requestValidator = new RequestValidator($routesUtil->getRoutes());
    $return = $requestValidator->processRequest();

} catch (Exception $e) {

    echo $e->getMessage();

}

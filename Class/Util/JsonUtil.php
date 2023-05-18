<?php

namespace Util;

use http\Exception\InvalidArgumentException;
use JsonException;

class JsonUtil
{
    public function treatJsonBody()
    {
        try {
            $postJson = json_decode(file_get_contents('php://input'), true);

        } catch (JsonException $e) {
            throw new InvalidArgumentException(GenericConstsUtil::MSG_ERROR_EMPTY_JSON);
        }

        if (is_array($postJson) && count($postJson) > 0) {
            return $postJson;
        }
    }

    public function proccessReturn($returned)
    {
        $data = [];
        $data[GenericConstsUtil::TYPE] = GenericConstsUtil::TYPE_ERROR;

        if ((is_array($returned) && count($returned) > 0) || strlen($returned) > 1) {//todo: improve
            $data[GenericConstsUtil::TYPE] = GenericConstsUtil::TYPE_SUCCESS;
            $data[GenericConstsUtil::DATA] = $returned;
        }

        $this->returnJson($data);
    }

    private function returnJson(array $json)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');

        echo json_encode($json);
    }
}
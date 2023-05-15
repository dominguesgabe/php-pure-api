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
}
<?php

namespace Util;

abstract class GenericConstsUtil
{
//    REQUESTS
    public const REQUEST_TYPE = ['GET', 'POST', 'PUT', 'DELETE'];
    public const TYPE_GET = ['USERS'];
    public const TYPE_POST = ['USERS'];
    public const TYPE_PUT = ['USERS'];
    public const TYPE_DELETE = ['USERS'];

//    ERRORS
    public const MSG_ERROR_TYPE_ROUTE = 'Not allowed route.';
    public const MSG_ERROR_NON_EXISTENT_RESOURCE = 'Non-existent resource.';
    public const MSG_ERROR_GENERIC = 'An error occurred with the request.';
    public const MSG_ERROR_NO_RETURN = 'No record found.';
    public const MSG_ERROR_NOT_AFFECTED = 'No record affected.';
    public const MSG_ERROR_EMPTY_TOKEN = 'Authentication token required.';
    public const MSG_ERROR_EMPTY_JSON = 'Requisition body can not be empty.';
    public const MSG_ERROR_UNAUTHORIZED_TOKEN = 'Unauthorized token.';

//    SUCCESS
    public const MSG_SUCCESS_DELETED = 'Successfully deleted.';
    public const MSG_SUCCESS_UPDATED = 'Successfully updated.';

//    RESOURCE USERS
    public const MSG_ERROR_REQUIRED_ID = 'Required ID.';
    public const MSG_ERROR_EXISTENT_LOGIN = 'This login already exists.';
    public const MSG_ERROR_REQUIRED_PASSWORD = 'Rquired password.';

//    JSON RETURN
    public const TYPE_SUCCESS = 'Success';
    public const TYPE_ERROR = 'Error';

//    OTHERS
    public const YES = 'Y';
    public const TYPE = 'type';
    public const DATA = 'data';
}
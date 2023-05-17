<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ERROR);

const HOST = 'php-api-db';
const DATABASE = 'php_api';
const USER = 'root';
const PASSWORD = '123';
const DS = DIRECTORY_SEPARATOR;
const DIR_APP = __DIR__;
const DIR_PROJECT = 'api';

if (file_exists('autoload.php')) {
    include 'autoload.php';
} else {
    echo 'Error including bootstrap.php';
    exit;
}
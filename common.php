<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
header('Content-Type: text/html; charset=utf-8');

defined('BASE_PATH')
    || define('BASE_PATH', realpath(dirname(__FILE__)));

#path to autoloader
require_once 'UniversalClassLoader.php';

$classLoader = new Symfony\Component\ClassLoader\UniversalClassLoader;
$classLoader->registerNamespaces(array(
    'Library' => BASE_PATH
));
$classLoader->register();
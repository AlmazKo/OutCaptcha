<?php
defined('BASE_PATH')
    || define('BASE_PATH', realpath(dirname(__FILE__)));

#path to autoloader
require_once BASE_PATH . '/Library/ClassLoader/UniversalClassLoader.php';

$classLoader = new Symfony\Component\ClassLoader\UniversalClassLoader('/tmp', 'classes');
$classLoader->registerNamespaces(array(
    'Library' => BASE_PATH
));
$classLoader->register();

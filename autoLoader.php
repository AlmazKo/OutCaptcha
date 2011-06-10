<?php

defined('BASE_PATH')
    || define('BASE_PATH', realpath(dirname(__FILE__)));

#path to autoloader
require_once '/home/almazko/Downloads/Symfony/vendor/symfony/src/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$classLoader = new Symfony\Component\ClassLoader\UniversalClassLoader;
$classLoader->registerNamespaces(array(
    'Library' => BASE_PATH
));
$classLoader->register();
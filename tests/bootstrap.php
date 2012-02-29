<?php
//defined('APP_PATH') || define('APP_PATH', __DIR__ . '/../');


require_once __DIR__ . '/../vendors/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$classLoader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
$classLoader->registerNamespaces(array(
    'OutCaptcha' => __DIR__ . '/../'
));
$classLoader->register();

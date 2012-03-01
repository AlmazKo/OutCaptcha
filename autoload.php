<?php
#path to autoloader
require_once __DIR__ . '/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$classLoader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
$classLoader->registerNamespaces(array(
    'OutCaptcha' => __DIR__,
    'ECurl' => __DIR__ . '/vendor'
));
$classLoader->register();

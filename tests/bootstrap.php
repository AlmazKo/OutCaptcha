<?php
defined('DICTIONARY_PATH')
    || define('DICTIONARY_PATH', realpath(__DIR__ . '/OutCaptcha/dic/'));

require_once __DIR__ . '/../vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$classLoader = new \Symfony\Component\ClassLoader\UniversalClassLoader();
$classLoader->registerNamespaces(array(
    'OutCaptcha' => __DIR__ . '/../'
));
$classLoader->register();

//\OutCaptcha\Dictionary::
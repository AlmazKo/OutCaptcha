<?php

use \Library\OutCaptcha\Captcha,
    \Library\OutCaptcha\ImageCaptcha as Image,
    \Library\OutCaptcha\Dictionary;

require_once 'common.php';

$begin = microtime(true);
$tpl = BASE_PATH . '/tpl/';
if (!empty($_REQUEST)) {
    $validAnswer = $_SESSION['answer'];
    $userAnswer = $answer = mb_strtolower($_REQUEST['answer'], 'utf-8');
    $pathToImg =  $_SESSION['path'];
    if (is_array($validAnswer) && in_array($userAnswer, $validAnswer, true) 
        ||  $userAnswer === $validAnswer) {
        $tpl .= 'ok.php';
    } else {
        $tpl .= 'error.php';
    }
} else {
    $options = array(
        'number_images'  => 3,
        'image_provider' => 'google',
        'path_images'    => '/var/www/images/');
    $captcha = new Captcha($options);
    $dic = new Dictionary('ru');
    $word = $dic->getRandom();
    $captcha = $captcha->get($word['question'], $options);
    $path = $captcha->getPath();
    $path = str_replace('/var/www', '', $path);
    $_SESSION['path'] = $pathToImg = $path;
    $_SESSION['answer'] = $word['answer'];
    $tpl .= 'start.php';
}
$time = (microtime(true) - $begin);
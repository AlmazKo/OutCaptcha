<?php

use \OutCaptcha\Captcha;
use OutCaptcha\Dictionary;
use OutCaptcha\Options;

$begin = microtime(true);

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
header('Content-Type: text/html; charset=utf-8');

require_once '../autoload.php';

if (!$_POST) {
    $options = new Options();
    $options->generatedCaptchaPath = '/tmp/outcaptcha/';
    $options->captchaBaseImage = array(460, 200);
    $captcha = new OutCaptcha($options);
    $dic = new Dictionary('ru');
    $word = $dic->getRandom();
    $decorator = function(Image $image){
        $image->addBorder(4);
        $image->rotate(rand(-10,10));
    };
    $captcha = $captcha->generate($word['question'], $decorator);

    $path = $captcha->getPath();
    $webPath = str_replace('/tmp/outcaptcha/', 'images/outcaptcha/', $path);
    $_SESSION['path'] = $webPath;
    $_SESSION['answer'] = $word['answer'];
    $tpl = 'start.php';
} else {
    $validAnswer = $_SESSION['answer'];
    $userAnswer = $answer = mb_strtolower($_REQUEST['answer'], 'utf-8');
    $pathToImg = $_SESSION['path'];
    if (is_array($validAnswer) && in_array($userAnswer, $validAnswer, true)
            || $userAnswer === $validAnswer) {
        $tpl = 'ok.php';
    } else {
        $tpl = 'error.php';
    }
}

$tpl = 'tpl/' . $tpl;
$time = (microtime(true) - $begin);
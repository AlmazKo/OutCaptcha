<?php

use OutCaptcha\OutCaptcha;
use OutCaptcha\Dictionary;
use OutCaptcha\Options;
use OutCaptcha\Image;

$begin = microtime(true);

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
header('Content-Type: text/html; charset=utf-8');

require_once '../autoload.php';

if (!$_POST) {
    $options = new Options();
    $options->generatedCaptchaPath = '/tmp/outcaptcha/';
    $options->imagesProvider = 'Google';
    $options->captchaBaseImage = array(460, 200);
    $captcha = new OutCaptcha($options);
    $dic = new Dictionary('en');
    list($question, $answer) = $dic->getRandom();
    $decorator = function(Image $image){
        $image->addBorder(5);
        return array(rand(-9, 29), rand(-10, 50));
    };
    $path = $captcha->generate($question, $decorator);

    $webPath = str_replace('/tmp/outcaptcha/', '/images/outcaptcha/', $path);
    $_SESSION['path'] = $webPath;
    $_SESSION['answer'] = $answer;
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
$time = round(microtime(true) - $begin, 4) . ' sec';

$addr = $_SERVER['PHP_SELF'];
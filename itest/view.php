<?php

use OutCaptcha\OutCaptcha;
use OutCaptcha\Dictionary;
use OutCaptcha\Options;
use OutCaptcha\Image;
use OutCaptcha\ImagesProvider\Google;
use OutCaptcha\OfflineCrawler;

$begin = microtime(true);

error_reporting(E_ALL);
ini_set('display_errors', 'On');

session_start();
header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/OfflineCrawler.php';

$options = new Options();
$options->generatedCaptchaPath = '/tmp/outcaptcha/';
$options->captchaBaseImage = array(460, 200);
$options->imagesNumber = 5;
$captcha = new OutCaptcha($options);

$captcha->setImageProvider(new Google(new OfflineCrawler()));
$dic = new Dictionary('ru');
list($question, $answer) = $dic->getRandom();
$decorator = function(Image $image) {
            $image->rotate(rand(0, 18));
            $image->addBorder(4, array(177, 177, 177));
            return array(rand(-50, 20), rand(0, 29));
        };
$path = $captcha->generate($question, $decorator);

$webPath = str_replace('/tmp/outcaptcha/', '/images/outcaptcha/', $path);

$time = round(microtime(true) - $begin, 4);
?><img src="<? echo $webPath ?>"> <? echo $time ?> sec
<?php

use \Library\OutCaptcha\Captcha,
    \Library\OutCaptcha\ImageCaptcha as Image,
    \Library\OutCaptcha\Dictionary;

error_reporting(E_ALL);
ini_set('display_errors', 'On');
session_start();
header('Content-Type: text/html; charset=utf-8');

//
//$d1 = new DateTime();
//$d2 = new DateTime();
//$d2->add(new DateInterval("P1M"));
//var_dump($d1);
//var_dump($d2);
//die;
require_once 'autoLoader.php';




$begin = microtime(true);

if (!empty($_REQUEST)) {
    if ($_SESSION['answer'] == $_REQUEST['answer']) {
        ?>
        <h3>Поздравяем, вы Человек!</h3>
        <img src="<?= $_SESSION['path'] ?>" />
        <br />Это действительно <b><?= $_SESSION['answer'] ?></b>
        <?
    } else {
        ?>

        <img src="<?= $_SESSION['path'] ?>" />
        <br />Ошибка, это не <b><?= $_REQUEST['answer'] ?></b>
        <form action="/out" method="GET">
            <input type="text" name="answer">
            <input type="submit"/>
        </form>

        <?
    }
} else {
    $captcha = new Captcha();
    $dic = Dictionary::get('ru');
    $ask = array_rand($dic);
    $answer = $dic[$ask];
    $captcha = $captcha->get($ask);
    $path = $captcha->getPath();
    $path = str_replace('/var/www', '', $path);
    $_SESSION['path'] = $path;
    $_SESSION['answer'] = $answer;
    ?>
    <h3>Что изображено на картинке?</h3>
    <img src="<?= $_SESSION['path'] ?>" />
    <form action="/out" method="GET">
        <input type="text" name="answer">
        <input type="submit"/>
    </form>

    <?
}








var_dump(microtime(true) - $begin);

<?php require_once 'captcha.php';
?><!DOCTYPE html>
<html>
    <head>
        <title>OutCaptcha</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
           
        </style>
    </head>
    <body>
        <div id="block_captcha"> <?=$time?>
            <?php include_once $tpl?>
        </div>
    </body>
</html>

<?php require_once 'captcha.php';
?><!DOCTYPE html>
<html>
    <head>
        <title>OutCaptcha</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
            body { margin: 5px;font-family: Helvetica, arial, sans-serif}
            #block_captcha { background-color: #bdb; width: 460px; padding: 10px; border-radius: 5px;text-align: center;}
            #block_captcha .comment{margin: 5px; text-align: left;}

        </style>
    </head>
    <body>
        <div id="block_captcha"> 
            <?php include_once $tpl ?>
        </div>
        <?php echo $time ?>
    </body>
</html>

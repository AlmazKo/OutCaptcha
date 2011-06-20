<?php require_once 'captcha.php';
?><!DOCTYPE html>
<html>
    <head>
        <title>OutCaptcha</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <style type="text/css">
            #block_captcha {
                float: left;
                border: 1px solid rgb(153, 153, 153);
                position: absolute;
                top: 40%;
                left: 50%;
                background-color: #0099CC;
                border-radius: 5px;
                -moz-border-radius:5px;
                -webkit-border-radius:5px;
                margin-left: -183px;
                margin-top: -70px;
                width:440px;
                color: #fff;
                font: 11pt Verdana, sans-serif;
            }
            #block_captcha p {
                margin: 5px;
                text-align: center;
            }
            
            #block_captcha .comment{
                margin: 5px;
                text-align: left;
            }
            
            #block_captcha input[type=text] {
                width: 340px;
                margin: 5px;
            }
            
            #block_captcha a {color: #afeeee}
            #block_captcha a:hover {color: #afeeee}
            #block_captcha a:visited {color: #afeeee}
            #block_captcha a:link {color: #afeeee}

        </style>
    </head>
    <body>
        <div id="block_captcha">
            <?php include_once $tpl?>
        </div>
    </body>
</html>

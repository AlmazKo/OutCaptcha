<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OutCaptcha;
/**
 * Description of Options
 * @author almazko <a.s.suslov@gmail.com>
 */
class Options {
    public $imagesNumber = 3;
    public $sizeSet = 10;
    public $imagesProvider = 'Google';
    public $downloadsPath;
    public $generatedCaptchaPath;
    
    /**
     * @var mixed $image Array($width, $height) or path to image
     */
    public $captchaBaseImage;
}

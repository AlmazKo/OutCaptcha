<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\OutCaptcha;
/**
 * Description of BuilderImage
 *
 * @author almazko
 */
class SimpleGdImageBuilder extends ImageBuilder {
    
    protected $_gd;
    public function __construct(array $options = array()) {
       
    }
    
    public function setImages(array $images) {
        return parent::setImages($images);
    }
    
    public function construct(array $options = array()) {
       // var_dump($this->_images);
       # $generalImage = \imagecreate(810, 850) or die("Cannot Initialize new GD image stream");
        $generalImage = \imagecreatetruecolor(500, 200) or die("Cannot Initialize new GD image stream");
        $background = \imagecolorallocate($generalImage, 255, 255, 255);
        $background2 = \imagecolorallocate($generalImage, 125, 0, 152);
        
        \imagefill($generalImage, 0, 0, $background); 
        
        
        $xDst = 0;
        foreach ($this->_images as $path) {
            $image = \imagecreatefromjpeg($path);
            
            
            
            $modImage = \imagerotate($image, rand(-10,10), $background2);
           // $modImage = $image;
            imagecolortransparent($modImage, $background2);
            $imageWidth = \imagesx($modImage);
            $imageHeight = \imagesy($modImage);
            \imagecopy($generalImage, $modImage, $xDst, rand(10,50), 0, 0, $imageWidth, $imageHeight);
            $xDst += \imagesx($image);
        }
        $path = $this->_pathForImages.  uniqid();
        $this->_captcha = new ImageCaptcha($path, \imagesx($generalImage), \imagesy($generalImage));
        \imagejpeg($generalImage, $path);
        \imagedestroy($generalImage);
        return $this;
    }
    
    public function getResult() {
        return $this->_captcha;
    }
}
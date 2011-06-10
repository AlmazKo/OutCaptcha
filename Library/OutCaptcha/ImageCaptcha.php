<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\OutCaptcha;
/**
 * Description of ImageCaptcha
 *
 * @author almazko
 */
class ImageCaptcha {
    protected $_path;
    protected $_height;
    protected $_width;
    
    public function __construct($pathToImage, $height, $width) {
        $this->_path = $pathToImage;
        $this->_height = $height;
        $this->_width = $width;
    }
    
    public function getWidth() {
        return $this->_width;
    }
    
    public function getHeight() {
        return $this->_height;
    }
    
    public function getPath() {
        return $this->_path;
    }
    
}


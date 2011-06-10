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
abstract class ImageBuilder {
    
    /**
     *
     * @var array 
     */
    protected $_images = array();
    
    protected $_pathForImages = array();

    public function __construct(array $options = array()) {
       
    }
    
    public function setPathForImages($pathForImages) {
        $this->_pathForImages = $pathForImages;
        return $this;
    }
    
    public function setImages(array $images) {
        $this->_images = $images;
        return $this;
    }
    
    abstract public function construct(array $options = array());
    
    abstract public function getResult();
    
}
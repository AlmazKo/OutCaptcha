<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\OutCaptcha;
/**
 * Description of Provider
 *
 * @author almazko
 */
abstract class Provider {
    
    protected $_pathForImages;
    /**
     *
     * @param string $query
     * @param int $selectCount
     * @param int $setCount 
     * @return array Array of urls images
     */
    abstract public function getImages($query, $selectCount, $setCount);
    
    /**
     *
     * @param string $pathForImages
     * @return Provider 
     */
    public function setPathForImages($pathForImages) {
        $this->_pathForImages = $pathForImages;
        return $this;
    }
    
    public function getPathForImages() {
        if (!$this->_pathForImages) {
            return '/tmp';
        }
        return $this->_pathForImages;
    }
}
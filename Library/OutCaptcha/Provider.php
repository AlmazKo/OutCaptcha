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
    
    /**
     *
     * @param string $query
     * @param int $selectCount
     * @param int $setCount 
     * @return array Array of urls images
     */
    abstract public function getImages($query, $selectCount, $setCount);
}
<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OutCaptcha;
/**
 * Description of Image
 * @author almazko <a.s.suslov@gmail.com>
 */
interface Image {

    public function __construct($path);

    public function addBorder($value, array $color);
    
    public function rotate($angle);
    
    public function resize($value);
    
    public function getWidth();
    public function getHeight();
    public function getInstance();
    
    public function setBackgroundColor(array $color);
    
    public function addImage(Image $image, $x, $y);
    
    public function save($path);
}

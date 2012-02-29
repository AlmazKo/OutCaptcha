<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OutCaptcha;
/**
 * Description of GdImage
 * @author almazko <a.s.suslov@gmail.com>
 */
class GdImage implements Image {

    /**
     *
     * @param mixed $image Array($width, $height) or path to image
     * @throws Exception 
     */
    public function __construct($image) {
        if (is_string($image) && is_file($image)) {
            $this->image = imagecreatefromjpeg($image);
        } elseif (is_array($image) && count($image) === 2) {
            $this->image = imagecreatetruecolor($image[0], $image[1]);
        } else {
            throw new Exception();
        }
        
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    public function addBorder($value, array $color = array(255, 255, 255)) {
        
        $borderColor = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
        
        $imageWithBorder = imagecreatetruecolor($this->width + $value * 2, $this->height + $value * 2);
        
        imagefill($imageWithBorder, 0, 0, $borderColor);
        imagecopy($imageWithBorder, $this->image, $value, $value, 0, 0, $this->width, $this->height);
        
        $this->image = $imageWithBorder;
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    public function resize($value) {
        
    }

    
    public function rotate($value, array $color = array(255, 255, 255) ) {
        $bgColor = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
        imagerotate($this->image, $value, $bgColor);
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
    }

    public function getHeight() {
        return $this->height;
    }

    public function getInstance() {
        return $this->image;
    }

    public function getWidth() {
     return $this->width;   
    }

    public function setBackgroundColor(array $color) {
        $fillColor = imagecolorallocate($this->image, $color[0], $color[1], $color[2]);
        imagefill($this->image, 0, 0, $fillColor); 
    }

    public function addImage(Image $image, $x, $y) {
        imagecopy($this->image, $image->getInstance(), $x, $y, 0, 0, $image->getWidth(), $image->getHeight());
    }

    public function save($path) {
        imagepng($this->image, $path);
    }
    
    protected function destroy() {
        if ($this->image) {
            imagedestroy($this->image);
        }
    }
    
    public function __destruct() {
        $this->destroy();
    }

}

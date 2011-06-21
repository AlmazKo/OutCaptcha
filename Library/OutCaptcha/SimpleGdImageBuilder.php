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
    protected $_templates = array();
    protected $_baseImageWidth  = 460,
              $_baseImageHeight = 200;
    
    protected $_avgImageWidth  = 110,
              $_avgImageHeight = 100;
    
    public function __construct(array $options = array()) {
       
    }
    
    /**
     * Получить шаблон расстановки картинок
     * @param type $count
     * @return type 
     */
    protected function _getTemplate($count) {
        $template = array();
        switch ($count) {
            case 1:
                $template[0]['x'] =  (int)($this->_baseImageWidth/2 - $this->_avgImageWidth/2 + rand (-10,10));
                $template[0]['x'] =  rand(10,40);
                break;
            case 2:
                $template[0]['x'] = (int)($this->_baseImageWidth/2 - $this->_avgImageWidth + rand (-20, 0));
                $template[0]['y'] = rand(10,40);
                
                $template[1]['x'] = (int)($this->_baseImageWidth/2 + rand (-10, 10));
                $template[1]['y'] = rand(10,40);

                break;
            
            case 3:
                $template[0]['x'] = rand (5, 30);
                $template[0]['y'] = rand(10,30);
                
                $template[1]['x'] = (int)($this->_baseImageWidth/2 - $this->_avgImageWidth/2 + rand (-20,0));
                $template[1]['y'] = rand(20,50);
                
                $template[2]['x'] = (int)($this->_baseImageWidth/2 + rand (30, 50));
                $template[2]['y'] = rand(10,30);
                break;
                
        }
        
        return $template;
    }
    
    public function setImages(array $images) {
        return parent::setImages($images);
    }
    
    public function construct(array $options = array()) {
        $generalImage = imagecreatetruecolor(460, 200) or die("Cannot Initialize new GD image stream");
        $background = imagecolorallocate($generalImage, 109,163,189);
        $background2 = imagecolorallocate($generalImage, 99, 199, 99);
        $background3 = imagecolorallocate($generalImage, 255, 255, 255);
        
        imagefill($generalImage, 0, 0, $background); 
        imagecolortransparent($generalImage, $background);
        
        $xDst = 10;
        $template = $this->_getTemplate(count($this->_images));
        
        
        $i = 0;
        foreach ($this->_images as $path) {
            $image = imagecreatefromjpeg($path);
            $imageWidth = imagesx($image);
            $imageHeight = imagesy($image);
            $imageWithBorder = imagecreatetruecolor($imageWidth + 10, $imageHeight + 10);
            imagefill($imageWithBorder, 0, 0, $background3); 
            imagecopy($imageWithBorder, $image, 5, 5, 0, 0, $imageWidth, $imageHeight);
            
            if (isset($options['rotate'])) {
                $modImage = imagerotate($imageWithBorder, rand(-10,10), $background2);
            } else {
                $modImage = $imageWithBorder;
            }

            imagecolortransparent($modImage, $background2);
            $imageWidth = imagesx($modImage);
            $imageHeight = imagesy($modImage);
            imagecopy($generalImage, $modImage, $template[$i]['x'], $template[$i]['y'], 0, 0, $imageWidth, $imageHeight);
            $xDst += imagesx($image);
            $i++;
        }
        $path = $this->_pathForImages.  uniqid();
        $this->_captcha = new ImageCaptcha($path, imagesx($generalImage), imagesy($generalImage));
        imagepng($generalImage, $path);
        imagedestroy($generalImage);
        return $this;
    }
    
    public function getResult() {
        return $this->_captcha;
    }
}
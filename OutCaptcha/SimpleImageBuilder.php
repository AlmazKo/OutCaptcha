<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OutCaptcha;
/**
 * Description of BuilderImage
 *
 * @author almazko
 */
class SimpleImageBuilder extends ImageBuilder {
    
    protected $_gd;
    protected $_templates = array();
    protected $_baseImageWidth  = 460,
              $_baseImageHeight = 200;
    
    protected $_avgImageWidth  = 110,
              $_avgImageHeight = 100;
    
    public function __construct($path) {
       $this->_pathForImages = $path;
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
    
    public function construct($baseImage, array $imagePaths, $decorator = null) {
        
        $baseImage = new GdImage($baseImage);
        $baseImage->setBackgroundColor(array(0,0,0));
       
//        imagecolortransparent($generalImage, $background);
        
        $xDst = 10;
        $template = $this->_getTemplate(count($imagePaths));
        
        $i = 0;
        foreach ($imagePaths as $path) {
            $image = new GdImage($path);
            $decorator($image);

            $baseImage->addImage($image, $template[$i]['x'], $template[$i]['y']);
            $xDst += $image->getWidth() + rand(5, 15);
            $i++;
        }
        $path = $this->_pathForImages.  uniqid();
        $baseImage->save($path);
        $this->path = $path;
        return  $path;
    }
    
    public function getPath() {
        return $this->path;
    }
}
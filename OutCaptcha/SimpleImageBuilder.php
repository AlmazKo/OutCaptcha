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

        $posX = 0;
        $posY = 0;
        $xDst = 10;
        $prevImage = 0;
        $template = $this->_getTemplate(count($imagePaths));
        
        $i = 0;
        foreach ($imagePaths as $path) {
            $image = new GdImage($path);
            $usersShift = $decorator($image);

            
            if ($usersShift && is_array($usersShift) && count($usersShift) > 1) {
                $shift = $usersShift;
            } else {
                $shift = array($template[$i]['x'], $template[$i]['y']);
            }
            $posX += $prevImage + $shift[0];
            $posY = $shift[1];
            if ($posX < 0) {
                $posX = 0;
            }
            if ($posX + $image->getWidth() > $baseImage->getWidth()) {
                $posX = $baseImage->getWidth() - $image->getWidth();
            }
            if ($posY < 0) {
                $posY = 0;
            }
            $baseImage->addImage($image, $posX, $posY);
            $xDst += $image->getWidth() + rand(5, 15);
            $i++;
            $prevImage = $image->getWidth();
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
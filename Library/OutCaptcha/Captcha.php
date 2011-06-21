<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\OutCaptcha;
/**
 * Description of Captcha
 *
 * @author almazko
 */
class Captcha {
    
    protected static $_defaultNumberOfImages = 3;
    protected static $_defaultSizeSet = 20;
    /**
     *
     * @var Provider
     */
    protected $_provider;
    
    /**
     *
     * @var ImageBuilder
     */
    protected $_imageBuilder;
    
    public function __construct(array $options = array()) {
        $this->setProvider(new ProviderGoogleImages(\BASE_PATH . '/tmp/images/'));
//        if (!empty($options['image_provider'])) {
//            $classProvider = "Provider" . ucfirst($options['image_provider']) . "Images";
//            $this->setProvider(new $classProvider(\BASE_PATH . '/tmp/images/'));
//        } else {
//            $this->setProvider(new ProviderGoogleImages(\BASE_PATH . '/tmp/images/'));
//        }
    }
    
    public function setProvider(Provider $provider) {
        $this->_provider = $provider;
    }
    
    public function setImageBuilder(ImageBuilder $builder) {
        $this->_imageBuilder = $builder;
    }
    
    public function getImageBuilder() {
        if (!$this->_imageBuilder) {
            $this->_imageBuilder = new SimpleGdImageBuilder();
        }
        return $this->_imageBuilder;
    }
    
    /**
     * Получить капчу (ссылку на картинку)
     * @param string $ask
     * @param array $options 
     * @return ImageCaptcha
     */
    public function get($ask, array $options = array()) {
        
        $numberOfImages = isset($options['number_images']) 
                        ? $options['number_images'] 
                        : self::$_defaultNumberOfImages;   
        
        $sizeSet = isset($options['size_set']) 
                 ? $options['size_set'] 
                 : self::$_defaultSizeSet;   
        
        $images = $this->_provider->setPathForImages('/var/www/images/')
                                ->getImages($ask, $numberOfImages, $sizeSet);

        $captcha = $this->getImageBuilder()
                              ->setPathForImages('/var/www/images/')
                              ->setImages($images)
                              ->construct()
                              ->getResult();
        
        return $captcha;
    }
    
    
}

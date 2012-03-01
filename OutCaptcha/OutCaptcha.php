<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha;

/**
 * Description of Captcha
 *
 * @author almazko
 */
class OutCaptcha {

    /**
     * @var Options 
     */
    protected $options;

    /**
     *
     * @var Provider
     */
    protected $imagesProvider;

    /**
     *
     * @var ImageBuilder
     */
    protected $_imageBuilder;

    public function __construct(Options $options)
    {
        $this->setOptions($options);
    }

    public function setOptions(Options $options)
    {
        $this->options = $options;
    }

    public function setImageProvider(ImagesProvider $provider)
    {
        $this->imagesProvider = $provider;
    }

    public function getImageProvider()
    {
        if (!$this->imagesProvider) {
            $classProvider = "OutCaptcha\ImagesProvider\\". ucfirst($this->options->imagesProvider);
            $crawler = new ECurlAdapter();
            $this->imagesProvider = new $classProvider($crawler, $this->options->downloadsPath);
        }
        return $this->imagesProvider;
    }

    public function setImageBuilder(ImageBuilder $builder)
    {
        $this->_imageBuilder = $builder;
    }

    public function getImageBuilder()
    {
        if (!$this->_imageBuilder) {
            $this->_imageBuilder = new SimpleImageBuilder($this->options->generatedCaptchaPath);
        }
        return $this->_imageBuilder;
    }

    /**
     * Получить капчу (ссылку на картинку)
     * @param string $ask
     * @param callback $decorator 
     * @return ImageCaptcha
     */
    public function generate($ask, $decorator = null)
    {

        $images = $this->getImageProvider()->getImages($ask, $this->options->imagesNumber, $this->options->sizeSet);

        $builder = $this->getImageBuilder();
        $builder->construct($this->options->captchaBaseImage, $images, $decorator);

        return $builder->getPath();
    }

}

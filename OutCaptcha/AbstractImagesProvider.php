<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha;

/**
 * Description of Provider
 *
 * @author almazko
 */
abstract class AbstractImagesProvider {

    const QUERY_TEMPLATE = '%QUERY%';
    /**
     * @var string
     */
    protected $downloadsPath;
    
    /**
     * @var Crawler
     */
    protected $crawler;

    /**
     * @param Crawler $crawler
     * @param string $downloadsPath 
     */
    public function __construct(Crawler $crawler, $downloadsPath = null)
    {
        $this->cralwer = $crawler;
        
        if (null === $downloadsPath) {
            $downloadsPath  = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'outcaptcha' . DIRECTORY_SEPARATOR;
            if (!is_dir($downloadsPath)) {
                mkdir($downloadsPath);
            }
            $this->downloadsPath = $downloadsPath; 
        } else {
            $this->downloadsPath = $downloadsPath;
        }
    }
    
    /**
     * {@inheritdoc }
     */
    public function getImages($query, $amount, $topImagesSize = null)
    {
        $findedImageUrls = $this->getImageUrls($query);

        if ($topImagesSize) {
            $findedImageUrls = array_slice($findedImageUrls, 0, $topImagesSize);
        }

        shuffle($findedImageUrls);

        return array_slice($findedImageUrls, 0, $amount);
    }
    
    abstract protected function getImageUrls($query);
}
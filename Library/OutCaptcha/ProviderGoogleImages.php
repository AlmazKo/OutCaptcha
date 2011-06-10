<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\OutCaptcha;


/**
 * Description of ProviderGoogleImages
 *
 * @author almazko
 */
class ProviderGoogleImages extends Provider {
    
    const MAX_SIZE_SET = 11;
    protected static $_url = 'http://www.google.com/search?hl=ru&biw=1920&bih=968&gbv=2&tbm=isch&sa=1&q=%QUERY%&oq=%QUERY%&aq=f&aqi=g10&aql=&gs_sm=e&gs_upl=29882l30776l0l7l6l0l0l0l0l225l1080l0.4.2';
    protected $_crawler;
    
    protected $_pathForImages;
    
    /**
     *
     * @param string $pathForImages
     * @param array $options 
     */
    public function __construct($pathForImages, array $options = array()) {
        
        $this->_pathForImages = $pathForImages;
        $this->_crawler = new \Library\Curl\Curl();
        $opt = array (CURLOPT_HEADER => true,
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_TIMEOUT => 20);
        $this->_crawler->setOptArray($opt);
    }
    
    public function getImages($query, $selectCount = 3, $sizeSet = self::MAX_SIZE_SET) {
         
//        $sizeSet = ($sizeSet > self::MAX_SIZE_SET) ? self::MAX_SIZE_SET : $sizeSet;
//        $selectCount = ($selectCount < 0) ? 1 : $selectCount;
//        $selectCount = ($selectCount > $sizeSet) ? $sizeSet : $selectCount;
        

        $targetUrl = str_replace('%QUERY%', urlencode($query), self::$_url);
        $response = $this->_crawler->requestGet($targetUrl)->getResponseBody();
       // $response = file_get_contents(BASE_PATH . '/Library/OutCaptcha/mockGoogleImages.html');
        preg_match_all('/http:\/\/[a-z0-9]+\.gstatic\.com\/images\?q\=tbn[^\'\"]+/', $response, $match);
        
        $findedImages = $match[0];
        
        if (!$findedImages) {
            throw new \Exception('Not found images');
        }
        if ($sizeSet) {
            $set = array_slice($findedImages, 0, $sizeSet);
        } else {
            $set = $findedImages;
        }
        shuffle($set);
        
        $images = array_slice($set, 0, $selectCount);
        return $images;
        
        $stub[] = 'http://t3.gstatic.com/images?q=tbn:ANd9GcRjn8VlTG6VVF0pdubv0RSpsfRa6koFrPRt1qtIczvICRMUHmODeQ';
        $stub[] = 'http://t1.gstatic.com/images?q=tbn:ANd9GcQN4pPzCnEcSbS7LLfC7BpJa8TiiTPISUWhQg7BC5rkGB8z85C3xQ';
        $stub[] = 'http://t0.gstatic.com/images?q=tbn:ANd9GcRt9IXhKw6oVh8jgPSk6Sdb-HfofaTSxCY6vH20-04U-W-yB6x3';
        return $stub;
    }
}

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
class ProviderYandexImages extends Provider {
    
    const MAX_SIZE_SET = 10;
    protected static $_url = 'http://images.yandex.ru/yandsearch?text=%QUERY%&rpt=image';
    protected $_crawler;
    
    protected $_pathForImages;
    
    /**
     *
     * @param string $pathForImages
     * @param array $options 
     */
    public function __construct($pathForImages, array $options = array()) {
        
        $this->_pathForImages = $pathForImages;
        $this->_crawler = new \Library\Curl\MultiCurl();
        $opt = array (//CURLOPT_HEADER => true,
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
        preg_match_all('/http:\/\/[a-z0-9-]+\.yandex\.net\/i\?id\=[^\'\"]+/', $response, $match);
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
        
        $urlOfImages = array_slice($set, 0, $selectCount);
        
        $images =  $this->_downloadImages($urlOfImages);
        
//        $images = array (
//              0 => '/var/www/images/img4dff813f3fcbb.jpg',
//              1 => '/var/www/images/img4dff813f42c90.jpg',
//              2 => '/var/www/images/img4dff813f42f3a.jpg',
//            );
        return $images;
        
        $stub[] = 'http://t3.gstatic.com/images?q=tbn:ANd9GcRjn8VlTG6VVF0pdubv0RSpsfRa6koFrPRt1qtIczvICRMUHmODeQ';
        $stub[] = 'http://t1.gstatic.com/images?q=tbn:ANd9GcQN4pPzCnEcSbS7LLfC7BpJa8TiiTPISUWhQg7BC5rkGB8z85C3xQ';
        $stub[] = 'http://t0.gstatic.com/images?q=tbn:ANd9GcRt9IXhKw6oVh8jgPSk6Sdb-HfofaTSxCY6vH20-04U-W-yB6x3';
        return $stub;
    }
    
    protected function _downloadImages(array $urls) {
        return $this->_crawler->downloadFiles($urls, $this->getPathForImages());
    }
}

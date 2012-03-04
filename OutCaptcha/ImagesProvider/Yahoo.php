<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha\ImagesProvider;

use OutCaptcha\AbstractImagesProvider;
use OutCaptcha\Exception;

/**
 * Description of ProviderGoogleImages
 *
 * @author almazko
 */
class Yahoo extends AbstractImagesProvider {

    /**
     * @var string 
     */
    protected static $urlTemplate = 'http://www.bing.com/images/search?q=%QUERY%&go=&form=QBLH&filt=all#x0y0';

    /**
     * 
     * @param string $query
     * @return array Array url of images
     * @throws Exception 
     */
    protected function getImageUrls($query)
    {
        $seek = array(static::QUERY_TEMPLATE, static::LANGUAGE_TEMPLATE);
        $replace = array(urlencode($query), static::$defaultLanguage);
        $url = str_replace($seek, $replace, self::$urlTemplate);
        $response = $this->cralwer->request('GET', $url);
        preg_match_all('/http\:\/\/[^\'\"]+/', $response, $findedImageUrls);

        if (!$findedImageUrls[0]) {
            throw new Exception('Not found images');
        }

        return $this->cralwer->downloadFiles($findedImageUrls[0], $this->downloadsPath);
    }

}

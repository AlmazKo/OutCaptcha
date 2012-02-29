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
class Google extends AbstractImagesProvider {

    /**
     * @var string 
     */
    protected static $urlTemplate = 'http://www.google.com/search?hl=ru&biw=1920&bih=968&gbv=2&tbm=isch&sa=1&q=%QUERY%&oq=%QUERY%&aq=f&aqi=g10&aql=&gs_sm=e&gs_upl=29882l30776l0l7l6l0l0l0l0l225l1080l0.4.2';

    /**
     * 
     * @param string $query
     * @return array Array url of images
     * @throws Exception 
     */
    protected function getImageUrls($query)
    {
        $url = str_replace(self::QUERY_TEMPLATE, urlencode($query), self::$urlTemplate);
        $response = $this->cralwer->request('GET', $url);
        preg_match_all('/http:\/\/[a-z0-9]+\.gstatic\.com\/images\?q\=tbn[^\'\"]+/', $response, $findedImageUrls);

        if (!$findedImageUrls[0]) {
            throw new Exception('Not found images');
        }

        return $this->cralwer->downloadFiles($findedImageUrls[0], $this->downloadsPath);
    }

}

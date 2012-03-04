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
class Yandex extends AbstractImagesProvider {

    /**
     * @var string 
     */
    protected static $urlTemplate = 'http://images.yandex.ru/yandsearch?text=%QUERY%&rpt=image';

    /**
     * 
     * @param string $query
     * @return array Array url of images
     * @throws Exception 
     */
    protected function getImageUrls($query)
    {
        $url = str_replace(static::QUERY_TEMPLATE, urlencode($query), self::$urlTemplate);
        $response = $this->cralwer->request('GET', $url);
        preg_match_all('/http:\/\/[a-z0-9-]+\.yandex\.net\/i\?id\=[^\'\"]+/', $response, $findedImageUrls);

        if (!$findedImageUrls[0]) {
            throw new Exception('Not found images');
        }

        return $this->cralwer->downloadFiles($findedImageUrls[0], $this->downloadsPath);
    }

}

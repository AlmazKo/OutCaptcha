<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha;

use ECurl\MultiCurl;
/**
 * Description of FilleDownloaderImpl
 * @author almazko <a.s.suslov@gmail.com>
 */
class ECurlAdapter implements Crawler {

    public function __construct() {
        $this->adaptee = new MultiCurl();
                $opt = array(//CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT => 20);
        $this->adaptee->setOptArray($opt);
    }
    
    public function downloadFile($url, $localPath)
    {
        
    }

    public function downloadFiles(array $urls, $localDir)
    {
        return $this->adaptee->downloadFiles($urls, $localDir);
    }

    public function request($type, $url)
    {
        return $this->adaptee->requestGet($url)->getResponseBody();
    }

}

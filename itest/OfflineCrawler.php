<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha;

use DirectoryIterator;
use OutCaptcha\Crawler;

/**
 * Description of MockCrawler
 * @author almazko <a.s.suslov@gmail.com>
 */
class OfflineCrawler implements Crawler {

    protected $images = array();

    public function __construct()
    {
        foreach (new DirectoryIterator(__DIR__ . '/images') as $fileinfo) {
            if ($fileinfo->isFile()) {
                $this->images[] = $fileinfo->getRealPath();
            }
        }
    }

    public function downloadFile($url, $localPath)
    {
        $image = $this->images[array_rand($this->images)];
        copy($image, $localPath . uniqid($image));
    }

    public function downloadFiles(array $urls, $localDir)
    {
        shuffle($this->images);

        $images = array_slice($this->images, 0, count($urls));
        $newPathImages = array();
        foreach ($images as $image) {
            $newFilePath = $localDir . uniqid(md5($image));
            copy($image, $newFilePath);
            $newPathImages[] = $newFilePath;
        }
        return $newPathImages;
    }

    public function request($type, $url)
    {
        return file_get_contents(__DIR__ . '/content/google.html');
    }

}

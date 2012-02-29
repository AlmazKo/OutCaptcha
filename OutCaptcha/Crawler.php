<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace OutCaptcha;
/**
 *
 * @author almazko
 */
interface Crawler {
     public function downloadFile($url, $localPath);
     public function downloadFiles(array $urls, $localDir);
     public function request($type, $url);
}
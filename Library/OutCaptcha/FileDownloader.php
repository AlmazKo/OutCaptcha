<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\OutCaptcha;
/**
 *
 * @author almazko
 */
interface FileDownloader {
     public function downloadFile($url, $path);
}
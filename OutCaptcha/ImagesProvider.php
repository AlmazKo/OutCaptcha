<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha;

/**
 * @author almazko <a.s.suslov@gmail.com>
 */
interface ImagesProvider {

    /**
     *
     * @param string $query
     * @param int $amount
     * @param int $topImagesSize 
     * @return array Array of urls images
     */
    public function getImages($query, $amount, $topImagesSize = null);
}

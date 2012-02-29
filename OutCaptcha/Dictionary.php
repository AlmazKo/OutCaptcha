<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace OutCaptcha;

/**
 * Description of Dictionary
 *
 * @author almazko
 */
class Dictionary {

    protected $dic = array();

    public function __construct($lang, $path) {

        $this->dic = json_decode(file_get_contents($path), true);
    }

    public function getRandom() {
        $ask = array_rand($this->dic);
        return array('question' => $ask, 'answer' => $this->dic[$ask]);
    }

    public static function getAll() {
        return $this->dic;
    }
}


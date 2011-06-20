<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\OutCaptcha;
/**
 * Description of Dictionary
 *
 * @author almazko
 */
class Dictionary {
    protected  $_dic = array();
    public function __construct($lang, $path = null) {
        if (null === $path) {
            $path = \BASE_PATH . '/dic/dictionary.'.$lang. '.json';
        }
       
        $this->_dic = json_decode(file_get_contents($path), true);
    }
    
    public function getRandom() {
        $ask = array_rand($this->_dic);
        return array('question' => $ask, 'answer'=> $this->_dic[$ask]);
    }
    
    public static function getAll() {
        return $this->_dic;
    }
}


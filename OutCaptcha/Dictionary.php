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

    /**
     * @var array 
     */
    protected $dic = array();

    public function __construct($source) {

        if (is_array($source)) {
            $this->dic = $source;
            return;
        } else if (!is_file($source)) {
            $source = __DIR__ . "/dic/$source.json";
        } 
        
        $this->dic = $this->getDictionaryContent($source);
    }

    /**
     * Get random Question & Answer
     * @return array array('question' => $ask, 'answer' => $answer)
     */
    public function getRandom() 
    {
        $ask = array_rand($this->dic);
        return array($ask, $this->dic[$ask]);
    }

    /**
     * Get all Dictionary
     * @return array 
     */
    public function getAll() {
        return $this->dic;
    }

    /**
     * @param string $question
     * @return string|array
     * 
     * @throws Exception 
     */
    public function getAnswer($question) {
        if (!array_key_exists($question, $this->dic)) {
            return;
        }
        
        return $this->dic[$question];
    }

    /**
     *
     * @param string $path
     * @return type
     * @throws Exception 
     */
    protected static function getDictionaryContent($path) 
    {
        if (!is_readable($path)) {
            throw new Exception('Not read dictionary-file: ' . $path);
        }
        
        return json_decode(file_get_contents($path), true);;
    }
}


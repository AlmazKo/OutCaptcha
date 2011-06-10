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
    protected static $dic = array(
    'Путин' => 'Путин',
    'Небо' => 'небо',
    'Гроза' => 'гроза',
    'Собака' => 'собака',
    'Яблоко' => 'яблоко',
    'Ганди' => 'Ганди',
    'Небо' => 'небо',
    'Луна' => 'луна',
    'Пушкин' => 'Пушкин',
    'Кошка' => 'кошка',
    'Компьютер' => 'компьютер',
    'Груша' => 'Груша',
    'Гриб' => 'гриб',
    'Комар' => 'комар',
    'Толстой' => 'Толстой',
    'самолет' => 'самолет',
    'вертолет' => 'вертолет',
    'пустыня' => 'пустыня',
    'рыцарь' => 'рыцарь',
    'снежинка' => 'снежинка',
    'крюк' => 'крюк',
    'тапок' => 'тапок',
    'кровать' => 'кровать',
    'Окна' => 'окно',
    'Верблюд' => 'верблюд',
    
);
    public function __construct($lang = null) {
        
    }
    
    public static function  get() {
        return self::$dic;
    }
    public function getRandowWord() {
        
    }
}


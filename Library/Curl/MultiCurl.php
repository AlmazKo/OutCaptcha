<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Library\Curl;
/**
 * Description of MultiCurl
 *
 * @author almazKo
 */
class MultiCurl extends Curl {
    
    protected $_pathToDownloadedFiles;
    
    protected $_mh;
    protected $_listCh = array();
    protected $_defaultOptions = array();
    
    protected $_result = array();
    
    public function __construct() {
        parent::__construct();
        $this->_mh = curl_multi_init();
    }
    function setDefaultOptions($options) {
       // return $this->getOpts();
    }
    
    public function downloadFiles(array $resources, $dir = null) {
        foreach($resources as $resource) {
            if ($resource && is_string($resource)) {
                $this->_listCh[] = curl_init($resource);
                $opts = $this->getOpts();
                $opts[CURLOPT_URL] = $resource;
                curl_setopt_array(end($this->_listCh), $opts);
                curl_multi_add_handle($this->_mh, end($this->_listCh));
            } elseif ($resource instanceof Curl) {
                
            }
        }
        $this->_pathToDownloadedFiles = $dir;
        $this->_run(array('static', '_downloadFile'));
        return $this->_result;
    }
    
    function _downloadFile($content, $dir = null, $fileName = null) {
            $this->_parseResponse(false);
            $content = $this->_responseRaw;
            var_dump($content);
        if (null === $dir) {
            $dir = $this->_pathToDownloadedFiles;
        }
        if (null === $fileName) {
            $fileName = uniqid('img');
        }
        
        $path = $this->_pathToDownloadedFiles . $fileName . '.jpg';
                @unlink($path);
                
        //        var_dump($content,"\n");
        $fd = fopen($path, 'a');
        fwrite($fd, $content);
        fclose($fd);
        
//        parent::_downloadFile($content, $path); 
        $this->_result[] = $path;
        
    }
    
    protected function _run($callback) {
        // количество активных потоков
        $active = null;
        // запускаем выполнение потоков
        do {
            $mrc = curl_multi_exec($this->_mh, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);

        // выполняем, пока есть активные потоки
        while ($active && ($mrc == CURLM_OK)) {
            // если какой-либо поток готов к действиям
            if (curl_multi_select($this->_mh) != -1) {
                // ждем, пока что-нибудь изменится
                do {
                    $mrc = curl_multi_exec($this->_mh, $active);
                    // получаем информацию о потоке
                    $info = curl_multi_info_read($this->_mh);

                    // если поток завершился
                    if ($info['msg'] == CURLMSG_DONE) {
                     //$this->_mh   var_dump($info);
                        $ch = $info['handle'];
                        // забираем содержимое
                        $this->_info = curl_getinfo($ch);
                        var_dump($info);
                        $this->_responseRaw = curl_multi_getcontent($ch);
                        call_user_func($callback, array('1'));
                        // удаляем поток из мультикурла
                       // var_dump(curl_getinfo($ch));
                        curl_multi_remove_handle($this->_mh, $ch);
                        // закрываем отдельное соединение (поток)
                        curl_close($ch);
                    }
                }
                while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }
        }
    }
    public function __destruct() {
        parent::__destruct();
        curl_multi_close($this->_mh);
    }
}
<?php

namespace Symfony\Component\ClassLoader;

require_once __DIR__ . '/UniversalClassLoader.php';

/**
 * Class loader utilizing APC to remember where files are.
 *
 * @author almazKo
 *
 * @api
 */
class CacheUniversalClassLoader extends UniversalClassLoader {
    const CACHE_FULL = 0;
    const CACHE_NAME_FILES = 1;
    /**
     * Массив запрошенных и найденных классов
     * @var array 
     */
    private static $_requiredClasses = array();
    private $_cacheDir;
    private $_nameCache;
    private $_way;
    private $_cachePath;

    /**
     * Constructor.
     *
     * @param string $prefix A prefix to create a namespace in APC
     *
     * @api
     */
    public function __construct($cacheDir, $name, $way = self::CACHE_FULL) {

        $this->_cacheDir = $cacheDir;
        $this->_nameCache = $name;
        $this->_way = $way;

        if ($way === self::CACHE_FULL) {
            $this->_cachePath = $cacheDir . '/' . $name . '.php';
        } else {
            $this->_cachePath = $cacheDir . '/' . $name . '_path.php';
        }
        if (file_exists($this->_cachePath)) {
            require_once $this->_cachePath;
        }
    }

    public function findFile($class) {

        $file = parent::findFile($class);
        if ($file) {
            self::$_requiredClasses[$class] = $file;
        }


        return $file;
    }

    /**
     *
     * @return array name classes
     */
    static public function getRequiredClasses() {
        /*
         * переворачиваем массив чтобы грузились сначала родители классов, а потом только наследники
         */
        return array_reverse(array_keys(self::$_requiredClasses));
    }

    public function __destruct() {
        if (self::$_requiredClasses) {
            if ($this->_way === self::CACHE_FULL) {
                require_once __DIR__ . '/ClassCollectionLoader.php';
                ClassCollectionLoader::load(
                        self::getRequiredClasses(), $this->_cacheDir, $this->_nameCache, true
                );
            } else {
                $this->_writeCacheNameFiles();
            }
        }
    }

    private function _writeCacheNameFiles() {
        $classes = array_reverse(self::$_requiredClasses);

        //TODO баг если нет файла
        $result = preg_replace(
                array('/require "/', '/^\s*<\?php/', '/\?>\s*$/', '/\";/')
                , '', file_get_contents($this->_cachePath));

        $loadedFiles = explode(PHP_EOL, trim($result));
        //добавляем новые файлы к существуещим
        //TODO сделать этот функционал опциональным
        $classes = array_intersect($classes, $loadedFiles);

        $content = '<?php' . PHP_EOL;
        foreach ($classes as $class => $file) {
            $content .= 'require "' . $file . '";' . PHP_EOL;
        }
        self::_writeCacheFile($this->_cachePath, $content);
    }

    private function _writeCacheFile($file, $content) {
        $tmpFile = tempnam(dirname($file), basename($file));
        if (false !== @file_put_contents($tmpFile, $content) && @rename($tmpFile, $file)) {
            chmod($file, 0644);
            return;
        }

        throw new \Exception(sprintf('Failed to write cache file "%s".', $file));
    }

}

<?php

/**
 * This file is part of the Krystal Framework
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Scaffold\Service;

use Scaffold\Collection\StorageCollection;
use Krystal\Filesystem\FileManager;
use Krystal\Stdlib\ArrayUtils;
use Krystal\Text\TextUtils;

final class SkeletonService
{
    /**
     * Module directory
     * 
     * @var string
     */
    private $moduleDir;

    /**
     * State initialization
     * 
     * @param string $moduleDir Module directory
     * @return void
     */
    public function __construct($moduleDir)
    {
        $this->moduleDir = $moduleDir;
    }

    /**
     * Extracts mapper name from namespace
     * 
     * @param string $ns
     * @return string
     */
    public static function extractMapperFromNs($ns)
    {
        $parts = explode('\\', $ns);
        return array_pop($parts);
    }

    /**
     * Guess mapper property name to be used in class
     * 
     * @param string $ns Mapper namespace
     * @return string
     */
    public static function guessMapperPropertyName($ns)
    {
        return lcfirst(self::extractMapperFromNs($ns));
    }

    /**
     * Guess service name from mapper namespace
     * 
     * @param string $ns Mapper namespace
     * @return string
     */
    public static function guessServiceName($ns)
    {
        $mapper = self::extractMapperFromNs($ns);
        return str_replace('Mapper', 'Service', $mapper);
    }
    
    /**
     * Guess mapper name from its table
     * 
     * @param string $table
     * @return string
     */
    public static function guessName($table)
    {
        return TextUtils::studly($table) . 'Mapper';
    }

    /**
     * Returns database engines
     * 
     * @return array
     */
    public static function getEngines()
    {
        $stCollection = new StorageCollection();
        return self::valuefy($stCollection->getAll());
    }

    /**
     * Valuefy key with corresponding values
     * 
     * @param array $values
     * @return array
     */
    public static function valuefy(array $values)
    {
        return ArrayUtils::valuefy($values);
    }

    /**
     * Turns raw modules into compliant ones
     * 
     * @param array $modules
     * @return array
     */
    public static function parseModules(array $modules)
    {
        // Remove Scaffold from the list
        $modules = ArrayUtils::unsetByValue($modules, 'Scaffold');

        return self::valuefy($modules);
    }

    /**
     * Scan a folder for available data mappers
     * 
     * @param string $module Module name
     * @param string $engine Database engine name (MySQL, Memory, etc)
     * @return array
     */
    public function getMappers($module, $engine)
    {
        $output = array();

        // Directory path
        $dirPath = sprintf('%s/%s/Storage/%s', $this->moduleDir, $module, $engine);

        try {
            $mappers = FileManager::getDirTree($dirPath);

            foreach ($mappers as $file) {
                $fileName = FileManager::getFileName($file);

                // Mapper's namespace
                $ns = sprintf('\%s\Storage\%s\%s', $module, $engine, $fileName);
                $output[$ns] = $fileName;
            }

            return $output;

        } catch(\RuntimeException $e) {
            return false;
        }
    }

    /**
     * Creates empty directories inside a module
     * 
     * @param string $module Module name
     * @return boolean
     */
    private function createModuleDirs($module)
    {
        // Directory to be created
        $dirs = array(
            'Assets',
            'Config',
            'Controller',
            'Service',
            'View/Template',
            'Translations'
        );

        foreach ($dirs as $dir) {
            // Directory path to be created
            $dirPath = sprintf('%s/%s/%s', $this->moduleDir, $module, $dir);

            // Create it
            FileManager::createDir($dirPath);
        }

        return true;
    }

    /**
     * Writes file on the disk
     * 
     * @param string $dirPath
     * @param string $file File name
     * @param string $content Skeleton content (i.e generated PHP code)
     * @return boolean
     */
    private function writeFile($dirPath, $file, $content)
    {
        // Create directory if one doesn't exist
        FileManager::createDir($dirPath);

        // Generate file path
        $filePath = sprintf('%s/%s.php', $dirPath, $file);

        // And do save it!
        return file_put_contents($filePath, $content);
    }

    /**
     * Writes module content on the disk
     * 
     * @param string $module Module name
     * @param string $content Skeleton content (i.e generated PHP code)
     * @return boolean
     */
    public function saveModule($module, $content)
    {
        $dirPath = sprintf('%s/%s', $this->moduleDir, $module);

        return $this->writeFile($dirPath, 'Module', $content) && $this->createModuleDirs($module);
    }

    /**
     * Writes controller skeleton file on the disk
     * 
     * @param string $module Module name
     * @param string $controller Controller class name
     * @param string $content Skeleton content (i.e generated PHP code)
     * @return boolean
     */
    public function saveController($module, $controller, $content)
    {
        $dirPath = sprintf('%s/%s/Controller', $this->moduleDir, $module);

        return $this->writeFile($dirPath, $controller, $content);
    }

    /**
     * Writes service skeleton file on the disk
     * 
     * @param string $module Module name
     * @param string $service Service class name (without NS)
     * @param string $content Skeleton content (i.e generated PHP code)
     * @return boolean
     */
    public function saveService($module, $service, $content)
    {
        $dirPath = sprintf('%s/%s/Service', $this->moduleDir, $module);

        return $this->writeFile($dirPath, $service, $content);
    }

    /**
     * Writes data mapper skeleton file on the disk
     * 
     * @param string $module Module name
     * @param string $engine Database engine name (MySQL, Memory, etc)
     * @param string $mapper Mapper name
     * @param string $content Skeleton content (i.e generated PHP code)
     * @return boolean Depending on write success
     */
    public function saveMapper($module, $engine, $mapper, $content)
    {
        $dirPath = sprintf('%s/%s/Storage/%s', $this->moduleDir, $module, $engine);

        return $this->writeFile($dirPath, $mapper, $content);
    }
}

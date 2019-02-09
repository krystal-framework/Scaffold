<?php

namespace Scaffold\Service;

use Krystal\Filesystem\FileManager;

final class SkeletonWriter
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
     * Writes data mapper skeleton file on the disk
     * 
     * @param string $module Module name
     * @param string $engine Database engine name (MySQL, Memory, etc)
     * @param string $mapper Mapper name
     * @param string $content Skeleton content (i.e genrated PHP code)
     * @return boolean Depending on write success
     */
    public function saveMapper($module, $engine, $mapper, $content)
    {
        // Directory path
        $dirPath = sprintf('%s/%s/Storage/%s', $this->moduleDir, $module, $engine);

        // Create directory if one doesn't exist
        FileManager::createDir($dirPath);

        // Generate file path
        $filePath = sprintf('%s/%s.php', $dirPath, $mapper);

        // And do save it!
        return file_put_contents($filePath, $content);
    }
}

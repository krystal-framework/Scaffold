<?php

namespace Scaffold\Service;

use Scaffold\Collection\StorageCollection;
use Krystal\Stdlib\ArrayUtils;

final class MapperGenerator
{
    /**
     * Returns database engines
     * 
     * @return array
     */
    public static function getEngines() : array
    {
        $stCollection = new StorageCollection();
        return ArrayUtils::valuefy($stCollection->getAll());
    }

    /**
     * Turns raw modules into compliant ones
     * 
     * @param array $modules
     * @return array
     */
    public static function parseModules(array $modules) : array
    {
        // Remove Scaffold from the list
        $modules = ArrayUtils::unsetByValue($modules, 'Scaffold');

        return ArrayUtils::valuefy($modules);
    }
}

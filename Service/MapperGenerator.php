<?php

namespace Scaffold\Service;

use Scaffold\Collection\StorageCollection;
use Krystal\Stdlib\ArrayUtils;
use Krystal\Text\TextUtils;

final class MapperGenerator
{
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
}

<?php

/**
 * This file is part of the Krystal Framework
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Scaffold;

use Krystal\Application\Module\AbstractModule;

final class Module extends AbstractModule
{
    /**
     * Returns routes of this module
     * 
     * @return array
     */
    public function getRoutes()
    {
        $request = $this->getServiceLocator()->get('request');

        // Make it only work only on local machine
        if ($request->isLocal()) {
            return include(__DIR__) . '/Config/routes.php';
        }

        return array();
    }

    /**
     * Returns prepared service instances of this module
     * 
     * @return array
     */
    public function getServiceProviders()
    {
        return array(
        );
    }
}

<?php

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

<?php

/**
 * This file is part of the Krystal Framework
 * 
 * Copyright (c) No Global State Lab
 * 
 * For the full copyright and license information, please view
 * the license file that was distributed with this source code.
 */

namespace Scaffold\Controller;

final class Scaffold extends AbstractController
{
    /**
     * Renders home page
     * 
     * @return string
     */
    public function indexAction()
    {
        $items = array(
            array(
                'name' => 'Module',
                'description' => 'A module is a container of controllers, routes, mappers and services for particular task',
                'route' => 'Scaffold:Module@indexAction'
            ),

            array(
                'name' => 'Mapper',
                'description' => 'A mapper encapsulates common operations on a single table',
                'route' => 'Scaffold:Mapper@indexAction'
            ),

            array(
                'name' => 'Service',
                'description' => 'In MVC, a service is a bridge between data mapper and domain object (if any)',
                'route' => 'Scaffold:Service@indexAction'
            ),
            
            array(
                'name' => 'Controller',
                'description' => 'A controller responds to route matches',
                'route' => 'Scaffold:Controller@indexAction'
            )
        );

        return $this->view->render('index', array(
            'items' => $items
        ));
    }
}

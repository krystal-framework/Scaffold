<?php

return array(
    '/scaffold' => array(
        'controller' => 'Scaffold@indexAction'
    ),

    '/scaffold/module' => array(
        'controller' => 'Module@indexAction'
    ),

    '/scaffold/mapper' => array(
        'controller' => 'Mapper@indexAction'
    ),
    
    '/scaffold/mapper/generate' => array(
        'controller' => 'Mapper@generateAction'
    ),

    // Service generator
    '/scaffold/service' => array(
        'controller' => 'Service@indexAction'
    ),

    '/scaffold/controller' => array(
        'controller' => 'Controller@indexAction'
    )
);
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

use Scaffold\Service\SkeletonService;

/**
 * This controller is responsible for service generation
 */
final class Service extends AbstractController
{
    /**
     * Renders a service form
     * 
     * @return string
     */
    public function indexAction()
    {
        $ready = $this->request->hasQuery('module', 'engine');

        $writer = new SkeletonService($this->appConfig->getModulesDir());

        if ($this->request->isPost()) {
            return $this->generateAction();
        }

        // Grab mappers
        $mappers = $ready ? $writer->getMappers($this->request->getQuery('module'), $this->request->getQuery('engine')) : array();

        return $this->view->render('service', array(
            'modules' => SkeletonService::parseModules($this->moduleManager->getLoadedModuleNames()),
            'engines' => SkeletonService::getEngines(),
            'mappers' => $mappers,
            'ready' => $ready
        ));
    }

    /**
     * Generates a service
     * 
     * @return string
     */
    public function generateAction()
    {
        $input = array_merge($this->request->getPost(), $this->request->getQuery());

        // Append generated variables
        $input['mapperNs'] = $input['mapper'];
        $input['service'] = SkeletonService::guessServiceName($input['mapperNs']);
        $input['mapperProperty'] = SkeletonService::guessMapperPropertyName($input['mapperNs']);
        $input['mapper'] = SkeletonService::extractMapperFromNs($input['mapperNs']);
        
        $skeleton = $this->renderSkeleton('service', $input);

        $this->flashBag->set('success', 'Service object has been successfully generated');

        if (!empty($input['module']) && !empty($input['service'])){
            $writer = new SkeletonService($this->appConfig->getModulesDir());
            $writer->saveService($input['module'], $input['service'], $skeleton);
        }

        return $this->view->render('output', array(
            'skeleton' => htmlentities($skeleton)
        ));
    }
}

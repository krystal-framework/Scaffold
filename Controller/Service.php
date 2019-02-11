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

use Scaffold\Service\SkeletonWriter;

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

        $writer = new SkeletonWriter($this->appConfig->getModulesDir());

        if ($this->request->isPost()) {
            return $this->generateAction();
        }

        // Grab mappers
        $mappers = $ready ? $writer->getMappers($this->request->getQuery('module'), $this->request->getQuery('engine')) : array();

        return $this->view->render('service', array(
            'modules' => SkeletonWriter::parseModules($this->moduleManager->getLoadedModuleNames()),
            'engines' => SkeletonWriter::getEngines(),
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
        $input['service'] = SkeletonWriter::guessServiceName($input['mapperNs']);
        $input['mapperProperty'] = SkeletonWriter::guessMapperPropertyName($input['mapperNs']);
        $input['mapper'] = SkeletonWriter::extractMapperFromNs($input['mapperNs']);
        
        $skeleton = $this->renderSkeleton('service', $input);

        $this->flashBag->set('success', 'Service object has been successfully generated');

        $writer = new SkeletonWriter($this->appConfig->getModulesDir());
        $writer->saveService($input['module'], $input['service'], $skeleton);

        return $this->view->render('output', array(
            'skeleton' => htmlentities($skeleton)
        ));
    }
}

<?php

namespace Scaffold\Controller;

use Scaffold\Service\MapperGenerator;
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
            'modules' => MapperGenerator::parseModules($this->moduleManager->getLoadedModuleNames()),
            'mappers' => $mappers,
            'engines' => MapperGenerator::getEngines(),
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
        $input['service'] = MapperGenerator::guessServiceName($input['mapperNs']);
        $input['mapperProperty'] = MapperGenerator::guessMapperPropertyName($input['mapperNs']);
        $input['mapper'] = MapperGenerator::extractMapperFromNs($input['mapperNs']);
        
        $skeleton = $this->renderSkeleton('service', $input);

        $this->flashBag->set('success', 'Service object has been successfully generated');

        $writer = new SkeletonWriter($this->appConfig->getModulesDir());
        $writer->saveService($input['module'], $input['service'], $skeleton);

        return $this->view->render('output', array(
            'skeleton' => htmlentities($skeleton)
        ));
    }
}

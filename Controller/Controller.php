<?php

namespace Scaffold\Controller;

use Scaffold\Service\MapperGenerator;
use Scaffold\Service\SkeletonWriter;

/**
 * This controller is responsible for controller generation
 */
final class Controller extends AbstractController
{
    /**
     * Renders a form
     * 
     * @return string
     */
    public function indexAction()
    {
        if ($this->request->isPost()) {
            return $this->generateAction();
        }

        return $this->view->render('controller', array(
            'modules' => MapperGenerator::parseModules($this->moduleManager->getLoadedModuleNames()),
        ));
    }

    /**
     * Generates controller
     * 
     * @return string
     */
    public function generateAction()
    {
        $input = $this->request->getPost();

        $skeleton = $this->renderSkeleton('controller', $input);

        $writer = new SkeletonWriter($this->appConfig->getModulesDir());
        $writer->saveController($input['module'], $input['controller'], $skeleton);

        return $this->view->render('output', array(
            'skeleton' => htmlentities($skeleton)
        ));
    }
}

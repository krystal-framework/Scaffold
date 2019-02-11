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
            'modules' => SkeletonService::parseModules($this->moduleManager->getLoadedModuleNames()),
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

        $writer = new SkeletonService($this->appConfig->getModulesDir());
        $writer->saveController($input['module'], $input['controller'], $skeleton);

        return $this->view->render('output', array(
            'skeleton' => htmlentities($skeleton)
        ));
    }
}

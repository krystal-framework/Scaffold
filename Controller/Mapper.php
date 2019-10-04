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
 * This controller is responsible for data mapper generation
 */
final class Mapper extends AbstractController
{
    /**
     * Returns current database connection
     * 
     * @return mixed
     */
    private function getConnection()
    {
        return $this->db['mysql'];
    }

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

        return $this->view->render('mapper', array(
            'engines' => SkeletonService::getEngines(),
            'modules' => SkeletonService::parseModules($this->moduleManager->getLoadedModuleNames()),
            'tables' => SkeletonService::valuefy($this->getConnection()->fetchAllTables())
        ));
    }

    /**
     * Generates a mapper
     * 
     * @return string
     */
    public function generateAction()
    {
        // Request input data
        $input = $this->request->getPost();

        // Try to get a PK out of table
        $pk = $this->getConnection()->getPrimaryKey($input['table']);

        // Append PK if available
        if ($pk !== false) {
            $input['pk'] = $pk;
        }

        // If no mapper name provided, then do generate one
        if (empty($input['mapper'])) {
            $input['mapper'] = SkeletonService::guessName($input['table']);
        }

        $skeleton = $this->renderSkeleton('mapper', $input);

        $writer = new SkeletonService($this->appConfig->getModulesDir());
        $writer->saveMapper($input['module'], $input['engine'], $input['mapper'], $skeleton);

        $this->flashBag->set('success', sprintf('%s has been successfully generated!', $input['mapper']));
        return 1;
    }
}

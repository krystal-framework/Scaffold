<?php

namespace Scaffold\Controller;

use Scaffold\Service\SkeletonWriter;

/* This class is responsible for module generation */
final class Module extends AbstractController
{
    /**
     * Renders module form
     * 
     * @return string
     */
    public function indexAction()
    {
        if ($this->request->isPost()) {
            return $this->generateAction();
        }

        return $this->view->render('module');
    }

    /**
     * Generates a module
     * 
     * @return string
     */
    public function generateAction()
    {
        $input = $this->request->getPost();

        $skeleton = $this->renderSkeleton('module', $input);

        $writer = new SkeletonWriter($this->appConfig->getModulesDir());
        $writer->saveModule($input['module'], $skeleton);

        $this->flashBag->set('success', sprintf('Module "%s" has been successfully generated!', $input['module']));

        return $this->view->render('output', array(
            'skeleton' => htmlentities($skeleton)
        ));
    }
}

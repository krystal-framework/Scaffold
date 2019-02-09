<?php

namespace Scaffold\Controller;

use Scaffold\Service\MapperGenerator;
use Scaffold\Service\SkeletonWriter;

/**
 * This controller is responsible for data mapper generation
 */
final class Mapper extends AbstractController
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

        return $this->view->render('mapper', array(
            'engines' => MapperGenerator::getEngines(),
            'modules' => MapperGenerator::parseModules($this->moduleManager->getLoadedModuleNames())
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

        // Build form validator
        $formValudator = $this->createValidator(array(
            'input' => array(
                'source' => $input,
                'definition' => array(
                    'table' => array(
                        'required' => true,
                        'rules' => array(
                            'NotEmpty' => array(
                                'message' => 'Table name can not be blank'
                            )
                        )
                    ),
                    'mapper' => array(
                        'required' => true,
                        'rules' => array(
                            'NotEmpty' => array(
                                'message' => 'Mapper name can not be blank'
                            )
                        )
                    )
                )
            )
        ));

        if ($formValudator->isValid()) {

            $skeleton = $this->renderSkeleton('mapper', $input);

            $writer = new SkeletonWriter($this->appConfig->getModulesDir());
            $writer->saveMapper($input['module'], $input['engine'], $input['mapper'], $skeleton);

            $this->flashBag->set('success', sprintf('%s has been successfull generated!', $input['mapper']));

            return 1;
        } else {
            return $formValudator->getErrors();
        }
        
    }
}

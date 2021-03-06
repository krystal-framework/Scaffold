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

use Krystal\Application\Controller\AbstractController as CoreController;
use Krystal\Validate\Renderer;

abstract class AbstractController extends CoreController
{
    /**
     * Global stylesheet files
     * 
     * @var array
     */
    private $stylesheets = array(
        '@Site/bootstrap-4/css/bootstrap.min.css',
        '@Site/styles.css'
    );

    /**
     * Global scripts
     * 
     * @var array
     */
    private $scripts = array(
        '@Site/jquery-3.3.1.min.js',
        '@Site/bootstrap-4/js/bootstrap.min.js',
        '@Site/krystal.jquery.js'
    );

    /**
     * Renders a skeleton
     * 
     * @param string $template Skeleton template
     * @param array $vars Skeleton variables
     * @return string
     */
    final protected function renderSkeleton($template, array $vars = array())
    {
        $out = $this->view->renderRaw('Scaffold', 'skeleton', $template, $vars);

        return '<?php' . PHP_EOL . $out;
    }

    /**
     * This method automatically gets called when this controller executes
     * 
     * @return void
     */
    protected function bootstrap()
    {
        // Define the default renderer for validation error messages
        $this->validatorFactory->setRenderer(new Renderer\StandardJson());

        // Define a directory where partial template fragments must be stored
        $this->view->getPartialBag()
                   ->addPartialDir($this->view->createThemePath('Site', $this->appConfig->getTheme()).'/partials/');

        // Append required assets
        $this->view->getPluginBag()->appendStylesheets($this->stylesheets);

        // Append required script paths
        $this->view->getPluginBag()->appendScripts($this->scripts);

        // Add shared variables
        $this->view->addVariables(array(
            'isLoggedIn' => false
        ));

        // Define the main layout
        $this->view->setLayout('__layout__', 'Site');
    }
}

<?php

namespace Scaffold\Controller;

use Krystal\Application\Controller\AbstractController as CoreController;
use Krystal\Validate\Renderer;

abstract class AbstractController extends CoreController
{
    /**
     * Renders a skeleton
     * 
     * @param string $template Skeleton template
     * @param array $vars Skeleton variables
     * @return string
     */
    final protected function renderSkeleton($template, array $vars = array())
    {
        $out = $this->view->disableLayout()
                          ->setTheme('skeleton')
                          ->render($template, $vars);

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
        $this->view->getPluginBag()->appendStylesheets(array(
            '@Site/bootstrap/css/bootstrap.min.css',
            '@Site/styles.css'
        ));

        // Append required script paths
        $this->view->getPluginBag()->appendScripts(array(
            '@Site/jquery.min.js',
            '@Site/bootstrap/js/bootstrap.min.js',
            '@Site/krystal.jquery.js'
        ));

        // Add shared variables
        $this->view->addVariables(array(
            'isLoggedIn' => false
        ));

        // Define the main layout
        $this->view->setLayout('__layout__', 'Site');
    }
}

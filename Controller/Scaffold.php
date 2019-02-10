<?php

namespace Scaffold\Controller;

final class Scaffold extends AbstractController
{
    /**
     * Renders home page
     * 
     * @return string
     */
    public function indexAction()
    {
        return $this->view->render('index');
    }
}

<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class StateController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/states/")
     *
     * @return View
     */
    public function getStatesAction()
    {
        return $this->view([]);
    }
}

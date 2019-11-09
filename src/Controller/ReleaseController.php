<?php declare(strict_types=1);

namespace App\Controller;

use App\Repository\ReleaseRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class ReleaseController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/releases/")
     */
    public function getReleasesAction(ReleaseRepository $releaseRepository): View
    {
        $releases = $releaseRepository->findAll();

        $view = $this->view(['releases' => $releases]);
        $view->getContext()->addGroup('release_list');

        return $view;
    }

    /**
     * @Rest\Post("/releases/")
     */
    public function postReleaseAction(): View
    {
        return $this->view();
    }
}

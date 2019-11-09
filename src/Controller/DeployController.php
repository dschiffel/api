<?php declare(strict_types=1);

namespace App\Controller;

use App\DTO\Assembler\DeployAssembler;
use App\Repository\DeployRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

class DeployController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/deploys/")
     */
    public function getDeploysAction(DeployRepository $deployRepository, DeployAssembler $deployAssembler): View
    {
        // todo use pagination, order by
        $deploys = $deployRepository->findAll();

        $deployDTOs = [];
        foreach ($deploys as $deploy) {
            $deployDTOs[] = $deployAssembler->toDTO($deploy);
        }

        $view = $this->view(['deploys' => $deployDTOs]);
        $view->getContext()->addGroup('deploy_list');

        return $view;
    }

    /**
     * @Rest\Post("/deploys/")
     */
    public function postDeployAction(): View
    {
        return $this->view();
    }
}

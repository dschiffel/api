<?php declare(strict_types=1);

namespace App\Controller;

use App\DTO\Assembler\DeployAssembler;
use App\DTO\DeployDTO;
use App\Form\DeployType;
use App\Repository\DeployRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class DeployController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/deploys/")
     */
    public function getDeploysAction(DeployRepository $deployRepository, DeployAssembler $deployAssembler): View
    {
        // todo use pagination
        $deploys = $deployRepository->findBy([], ['createdAt' => 'desc']);

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
    public function postDeployAction(Request $request, DeployAssembler $deployAssembler): View
    {
        $deployDTO = new DeployDTO();
        $form = $this->createForm(DeployType::class, $deployDTO);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $deploy = $deployAssembler->fromDTO($deployDTO);

            $em = $this->getDoctrine()->getManager();
            $em->persist($deploy);
            $em->flush();

            return $this->view(); // todo return deploy dto
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }
}

<?php

namespace App\Controller;

use App\DTO\ApplicationDTO;
use App\DTO\Assembler\ApplicationAssembler;
use App\Entity\Application;
use App\Form\ApplicationType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ApplicationController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/apps")
     *
     * @param ApplicationAssembler $applicationAssembler
     * @return View
     */
    public function getApplications(ApplicationAssembler $applicationAssembler): View
    {
        $applications = $this->getDoctrine()->getRepository('App:Application')->findAll();

        $applicationDTOs = array_map(function (Application $application) use ($applicationAssembler) {
            return $applicationAssembler->toDTO($application);
        }, $applications);

        $view = $this->view(['applications' => $applicationDTOs]);
        $view->getContext()->addGroup('application_list');

        return $view;
    }

    /**
     * @Rest\Get("/apps/{app_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @param ApplicationAssembler $applicationAssembler
     * @return View
     */
    public function getApplication(Application $application, ApplicationAssembler $applicationAssembler): View
    {
        $applicationDTO = $applicationAssembler->toDTO($application);

        $view = $this->view(['application' => $applicationDTO]);
        $view->getContext()->addGroup('application_view')->setSerializeNull(true);

        return $view;
    }

    /**
     * @Rest\Post("/apps")
     *
     * @param Request $request
     * @param ApplicationAssembler $applicationAssembler
     * @return View
     */
    public function createApplication(ApplicationAssembler $applicationAssembler, Request $request): View
    {
        $applicationDTO = new ApplicationDTO();
        $form = $this->createForm(ApplicationType::class, $applicationDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $application = $applicationAssembler->fromDTO($applicationDTO);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->view(); // todo return application dto
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }

    /**
     * @Rest\Put("/apps/{app_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @param Request $request
     * @return View
     */
    public function updateApplication(Application $application, Request $request): View
    {
        throw new \Exception('To be implemented');
        $form = $this->createForm(ApplicationType::class, $application, ['method' => 'PUT']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }

    /**
     * @Rest\Delete("/apps/{app_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @return View
     */
    public function deleteApplication(Application $application): View
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($application);
        $em->flush();

        return $this->view();
    }
}

<?php

namespace App\Controller;

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
     * @Rest\Get("/applications")
     *
     * @return View
     */
    public function getApplications(): View
    {
        $applications = $this->getDoctrine()->getRepository('App:Application')->findAll();

        return $this->view(compact('applications'));
    }

    /**
     * @Rest\Get("/applications/{app_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @return View
     */
    public function getApplication(Application $application): View
    {
        return $this->view(compact('application'));
    }

    /**
     * @Rest\Post("/applications")
     *
     * @param Request $request
     * @return View
     */
    public function createApplication(Request $request): View
    {
        $application = new Application();
        $form = $this->createForm(ApplicationType::class, $application);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }

    /**
     * @Rest\Put("/applications/{app_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @param Request $request
     * @return View
     */
    public function updateApplication(Application $application, Request $request): View
    {
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
     * @Rest\Delete("/applications/{app_id}")
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

<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Environment;
use App\Form\EnvironmentType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

/**
 * Class EnvironmentController
 * @package App\Controller
 */
class EnvironmentController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/apps/{app_id}/envs")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @return View
     */
    public function getEnvironments(Application $application): View
    {
        $environments = $application->getEnvironments();

        return $this->view(compact('environments'));
    }

    /**
     * @Rest\Get("/apps/{app_id}/envs/{env_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     * @ParamConverter("environment", options={"id"="env_id"})
     *
     * @param Application $application
     * @param Environment $environment
     * @return View
     */
    public function getEnvironment(Application $application, Environment $environment): View
    {
        return $this->view(compact('environment'));
    }

    /**
     * @Rest\Post("/apps/{app_id}/envs")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @param Request $request
     * @return View
     */
    public function createEnvironment(Application $application, Request $request): View
    {
        $environment = new Environment();
        $environment->setApplication($application);
        $form = $this->createForm(EnvironmentType::class, $environment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($environment);
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }

    /**
     * @Rest\Put("/apps/{app_id}/envs/{env_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     * @ParamConverter("environment", options={"id"="env_id"})
     *
     * @param Application $application
     * @param Environment $environment
     * @param Request $request
     * @return View
     */
    public function updateEnvironment(Application $application, Environment $environment, Request $request): View
    {
        $form = $this->createForm(EnvironmentType::class, $environment, ['method' => 'PUT']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }

    /**
     * @Rest\Delete("/apps/{app_id}/envs/{env_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     * @ParamConverter("environment", options={"id"="env_id"})
     *
     * @param Application $application
     * @param Environment $environment
     * @return View
     */
    public function deleteEnvironment(Application $application, Environment $environment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($environment);
        $em->flush();

        return $this->view();
    }
}

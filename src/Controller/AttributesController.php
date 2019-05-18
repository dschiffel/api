<?php

namespace App\Controller;

use App\Entity\Application;
use App\Entity\Attribute;
use App\Form\AttributeType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AttributesController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/applications/{app_id}/attributes")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @return View
     */
    public function getAttributes(Application $application): View
    {
        $attributes = $application->getAttributes();

        return $this->view(compact('attributes'));
    }

    /**
     * @Rest\Get("/applications/{app_id}/attributes/{attr_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     * @ParamConverter("attribute", options={"id"="attr_id"})
     *
     * @param Application $application
     * @param Attribute $attribute
     * @return View
     */
    public function getAttribute(Application $application, Attribute $attribute): View
    {
        return $this->view(compact('attribute'));
    }

    /**
     * @Rest\Post("/applications/{app_id}/attributes")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @param Request $request
     * @return View
     */
    public function createAttribute(Application $application, Request $request): View
    {
        $attribute = new Attribute();
        $attribute->setApplication($application);
        $form = $this->createForm(AttributeType::class, $attribute);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($attribute);
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }

    /**
     * @Rest\Put("/applications/{app_id}/attributes/{attr_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     * @ParamConverter("attribute", options={"id"="attr_id"})
     *
     * @param Application $application
     * @param Attribute $attribute
     * @param Request $request
     * @return View
     */
    public function updateAttribute(Application $application, Attribute $attribute, Request $request): View
    {
        $form = $this->createForm(AttributeType::class, $attribute, ['method' => 'PUT']);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException(); // todo return form errors
    }

    /**
     * @Rest\Delete("/applications/{app_id}/attributes/{attr_id}")
     * @ParamConverter("application", options={"id"="app_id"})
     * @ParamConverter("attribute", options={"id"="attr_id"})
     *
     * @param Application $application
     * @param Attribute $attribute
     * @return View
     */
    public function deleteAttribute(Application $application, Attribute $attribute)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($attribute);
        $em->flush();

        return $this->view();
    }
}

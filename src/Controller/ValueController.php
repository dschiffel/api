<?php

namespace App\Controller;

use App\DTO\Assembler\ValueAssembler;
use App\DTO\ValueDTO;
use App\Entity\Application;
use App\Entity\Attribute;
use App\Entity\Environment;
use App\Entity\Value;
use App\Form\ValueType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ValueController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/applications/{app_id}/values")
     * @ParamConverter("application", options={"id"="app_id"})
     *
     * @param Application $application
     * @param Request $request
     * @param ValueAssembler $valueAssembler
     * @return View
     */
    public function setValueAction(Application $application, Request $request, ValueAssembler $valueAssembler)
    {
        $valueDTO = new ValueDTO();
        $form = $this->createForm(ValueType::class, $valueDTO);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $environment = $em->getRepository(Environment::class)->find($valueDTO->environmentId);
            $attribute = $em->getRepository(Attribute::class)->find($valueDTO->attributeId);
            $value = $em->getRepository(Value::class)->findOneBy([
                'attribute' => $attribute,
                'environment' => $environment,
            ]);

            $value = $valueAssembler->fromDTO($valueDTO, $value);
            if (!$em->contains($value)) {
                $em->persist($value);
            }
            $em->flush();

            return $this->view();
        }

        throw new UnprocessableEntityHttpException();
    }
}

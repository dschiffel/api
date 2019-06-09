<?php

namespace App\Controller;

use App\DTO\Assembler\ValueAssembler;
use App\DTO\ValueDTO;
use App\Entity\Attribute;
use App\Entity\Environment;
use App\Entity\Value;
use App\Form\ValueType;
use App\Repository\ValueRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ValueController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/values")
     *
     * @param Request $request
     * @param ValueAssembler $valueAssembler
     * @return View
     */
    public function setValueAction(Request $request, ValueAssembler $valueAssembler)
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

    /**
     * @Rest\Get("/values")
     * @ParamConverter("application", options={"id"="app_id"})
     * @ParamConverter("attribute", options={"id"="attr_id"})
     * @ParamConverter("environment", options={"id"="env_id"})
     *
     * @param Request $request
     * @param ValueRepository $valueRepository
     * @param ValueAssembler $valueAssembler
     * @return View
     */
    public function editValueAction(
        Request $request,
        ValueRepository $valueRepository,
        ValueAssembler $valueAssembler
    ) {
        $value = $valueRepository->findOneBy([
            'attribute' => $request->query->get('attrId'),
            'environment' => $request->query->get('envId'),
        ]);

        if ($value === null) {
            return $this->view([]);
        }

        $valueDTO = $valueAssembler->toDTO($value);

        $view = $this->view(['value' => $valueDTO]);
        $view->getContext()->addGroup('value_edit');

        return $view;
    }
}

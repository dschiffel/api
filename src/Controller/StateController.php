<?php

namespace App\Controller;

use App\DTO\Assembler\AttributeAssembler;
use App\DTO\Assembler\EnvironmentAssembler;
use App\DTO\Assembler\StateAssembler;
use App\Entity\Attribute;
use App\Entity\Environment;
use App\Entity\State;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

class StateController extends AbstractFOSRestController
{
    /**
     * @Rest\Get("/states/")
     */
    public function getStatesAction(
        EntityManagerInterface $em,
        EnvironmentAssembler $environmentAssembler,
        AttributeAssembler $attributeAssembler,
        StateAssembler $stateAssembler
    ) {
        $environments = $em->getRepository(Environment::class)->findAll();
        $environmentDTOs = [];
        foreach ($environments as $environment) {
            $environmentDTOs[] = $environmentAssembler->toDTO($environment);
        }

        $attributes = $em->getRepository(Attribute::class)->findAll();
        $attributeDTOs = [];
        foreach ($attributes as $attribute) {
            $attributeDTOs[] = $attributeAssembler->toDTO($attribute);
        }

        $states = $em->getRepository(State::class)->findAll();
        $stateDTOs = [];
        foreach ($states as $state) {
            $stateDTOs[] = $stateAssembler->toDTO($state);
        }

        $view = $this->view([
            'environments' => $environmentDTOs,
            'attributes' => $attributeDTOs,
            'states' => $stateDTOs,
        ]);
        $view->getContext()->addGroup('state_list');

        return $view;
    }
}

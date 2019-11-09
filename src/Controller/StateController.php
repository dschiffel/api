<?php

namespace App\Controller;

use App\DTO\Assembler\AttributeAssembler;
use App\DTO\Assembler\EnvironmentAssembler;
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
        AttributeAssembler $attributeAssembler
    ) {
        $environments = $em->getRepository(Environment::class)->findAll();
        $attributes = $em->getRepository(Environment::class)->findAll();
        $states = $em->getRepository(State::class)->findAll();

        // todo continue with changing StateDTO and StateAssembler
    }
}

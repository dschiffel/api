<?php

namespace App\EntityListener;

use App\Entity\Deploy;
use App\Entity\State;
use Doctrine\ORM\Event\LifecycleEventArgs;

class DeployListener
{
    public function postPersist(Deploy $deploy, LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $stateRepository = $em->getRepository(State::class);

        $environment = $deploy->getEnvironment();
        foreach ($deploy->getDeployAttributes() as $deployAttribute) {
            $attribute = $deployAttribute->getAttribute();
            $state = $stateRepository->findOneBy([
                'environment' => $environment,
                'attribute' => $attribute,
            ]);

            if ($state === null) {
                $state = new State();
                $state
                    ->setEnvironment($environment)
                    ->setAttribute($attribute);
            }

            $state->setValue($deployAttribute->getValue());
            $em->persist($state);
        }

        $em->flush();
    }
}

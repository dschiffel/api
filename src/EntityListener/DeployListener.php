<?php

namespace App\EntityListener;

use App\Entity\Deploy;
use App\Entity\DeployAttribute;
use App\Entity\State;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpClient\HttpClient;

class DeployListener
{
    private $slackUrl;

    public function __construct(string $slackUrl)
    {
        $this->slackUrl = $slackUrl;
    }

    public function postPersist(Deploy $deploy, LifecycleEventArgs $args)
    {
        $this->updateState($deploy, $args);
        $this->postToSlack($deploy);
    }

    private function updateState(Deploy $deploy, LifecycleEventArgs $args)
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

    private function postToSlack(Deploy $deploy)
    {
        $client = HttpClient::create();

        $text = sprintf(
            "%s has been deployed to *%s*",
            implode("\n", array_map(function (DeployAttribute $a) {
                return '*'.$a->getAttribute()->getTitle().'*: '.$a->getValue();
            }, $deploy->getDeployAttributes()->getValues())),
            $deploy->getEnvironment()->getTitle()
        );

        $client->request('POST', $this->slackUrl, [
            'json' => compact('text'),
        ]);
    }
}

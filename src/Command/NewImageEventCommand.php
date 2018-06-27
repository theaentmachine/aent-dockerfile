<?php

namespace TheAentMachine\AentDockerfile\Command;

use TheAentMachine\AentDockerfile\Aenthill\Enum\PheromoneEnum;
use TheAentMachine\JsonEventCommand;
use TheAentMachine\Service\Service;

class NewImageEventCommand extends JsonEventCommand
{

    protected function getEventName(): string
    {
        return 'NEW_IMAGE';
    }

    protected function executeJsonEvent(array $payload): ?array
    {
        $service = Service::parsePayload($payload);
        $serviceName = $service->getServiceName();
        $commands = $service->getDockerfileCommands();

        $dockerfileName = getenv(PheromoneEnum::PHEROMONE_CONTAINER_PROJECT_DIR.'/Dockerfile.'.$serviceName);

        file_put_contents($dockerfileName, $commands);

        return null;
    }
}

<?php

namespace TheAentMachine\AentDockerfile\Command;

use Symfony\Component\Filesystem\Filesystem;
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

        $dockerfileName = getenv('PHEROMONE_CONTAINER_PROJECT_DIR') . '/Dockerfile.' . $serviceName;

        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($dockerfileName, implode(PHP_EOL, $commands));

        return null;
    }
}

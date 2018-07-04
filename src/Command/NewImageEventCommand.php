<?php

namespace TheAentMachine\AentDockerfile\Command;

use Symfony\Component\Filesystem\Filesystem;
use TheAentMachine\JsonEventCommand;
use TheAentMachine\Pheromone;
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

        $dockerfileName = Pheromone::getContainerProjectDirectory() . '/Dockerfile.' . $serviceName;

        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($dockerfileName, implode(PHP_EOL, $commands));

        $dirInfo = new \SplFileInfo(\dirname($dockerfileName));
        chown($dockerfileName, $dirInfo->getOwner());
        chgrp($dockerfileName, $dirInfo->getGroup());
        return null;
    }
}

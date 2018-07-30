<?php

namespace TheAentMachine\AentDockerfile\Command;

use Symfony\Component\Filesystem\Filesystem;
use TheAentMachine\Command\AbstractJsonEventCommand;
use TheAentMachine\Aenthill\Pheromone;
use TheAentMachine\Service\Service;

class NewImageEventCommand extends AbstractJsonEventCommand
{

    protected function getEventName(): string
    {
        return 'NEW_IMAGE';
    }

    /**
     * @param array $payload
     * @return array|null
     * @throws \TheAentMachine\Exception\MissingEnvironmentVariableException
     * @throws \TheAentMachine\Service\Exception\ServiceException
     */
    protected function executeJsonEvent(array $payload): ?array
    {
        $service = Service::parsePayload($payload);
        $serviceName = $service->getServiceName();
        $commands = implode(PHP_EOL, $service->getDockerfileCommands()) . PHP_EOL;

        $dockerfileName = Pheromone::getContainerProjectDirectory() . '/Dockerfile.' . $serviceName;

        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($dockerfileName, $commands);

        $dirInfo = new \SplFileInfo(\dirname($dockerfileName));
        chown($dockerfileName, $dirInfo->getOwner());
        chgrp($dockerfileName, $dirInfo->getGroup());
        return null;
    }
}

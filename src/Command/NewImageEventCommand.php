<?php

namespace TheAentMachine\AentDockerfile\Command;

use Symfony\Component\Filesystem\Filesystem;
use TheAentMachine\Aenthill\CommonEvents;
use TheAentMachine\Aenthill\CommonMetadata;
use TheAentMachine\Aenthill\Manifest;
use TheAentMachine\Command\AbstractJsonEventCommand;
use TheAentMachine\Aenthill\Pheromone;
use TheAentMachine\Exception\ManifestException;
use TheAentMachine\Exception\MissingEnvironmentVariableException;
use TheAentMachine\Service\Exception\ServiceException;
use TheAentMachine\Service\Service;

class NewImageEventCommand extends AbstractJsonEventCommand
{

    protected function getEventName(): string
    {
        return CommonEvents::NEW_IMAGE_EVENT;
    }

    /**
     * @param mixed[] $payload
     * @return string[]|null
     * @throws ManifestException
     * @throws MissingEnvironmentVariableException
     * @throws ServiceException
     */
    protected function executeJsonEvent(array $payload): ?array
    {
        $service = Service::parsePayload($payload);
        $serviceName = $service->getServiceName();
        $commands = implode(PHP_EOL, $service->getDockerfileCommands()) . PHP_EOL;

        $envName = Manifest::mustGetMetadata(CommonMetadata::ENV_NAME_KEY);
        $dockerfileName = "Dockerfile.$envName.$serviceName";
        $dockerfilePath = Pheromone::getContainerProjectDirectory() . "/$dockerfileName";

        $fileSystem = new Filesystem();
        $fileSystem->dumpFile($dockerfilePath, $commands);

        $dirInfo = new \SplFileInfo(\dirname($dockerfilePath));
        \chown($dockerfilePath, $dirInfo->getOwner());
        \chgrp($dockerfilePath, $dirInfo->getGroup());

        $this->output->writeln("Dockerfile <info>$dockerfileName</info> has been successfully created!");

        return [$dockerfileName];
    }
}

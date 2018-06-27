<?php

namespace TheAentMachine\AentDockerfile\Aenthill\Exception;

use TheAentMachine\AentDockerfile\Aenthill\Enum\PheromoneEnum;
use TheAentMachine\Exception\AenthillException;

class ContainerProjectDirEnvVariableEmptyException extends AenthillException
{
    /**
     * ContainerProjectDirNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('environment variable ' . PheromoneEnum::PHEROMONE_CONTAINER_PROJECT_DIR . ' is empty');
    }
}

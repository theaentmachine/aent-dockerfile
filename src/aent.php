#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use TheAentMachine\AentApplication;
use TheAentMachine\AentDockerfile\Command\NewImageEventCommand;
use TheAentMachine\Command\CannotHandleAddEventCommand;

$application = new AentApplication();

$application->add(new CannotHandleAddEventCommand());
$application->add(new NewImageEventCommand());

$application->run();

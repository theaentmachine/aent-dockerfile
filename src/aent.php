#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use TheAentMachine\AentApplication;
use TheAentMachine\AentDockerfile\Command\AddEventCommand;
use TheAentMachine\AentDockerfile\Command\NewImageEventCommand;

$application = new AentApplication();

$application->add(new AddEventCommand());
$application->add(new NewImageEventCommand());

$application->run();

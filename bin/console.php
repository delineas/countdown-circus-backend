#!/usr/bin/env php
<?php

use DI\ContainerBuilder;
use Symfony\Component\Console\Application;


$rootPath = realpath(__DIR__ . '/..');

require $rootPath . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require $rootPath . '/bootstrap/settings.php';
$settings($containerBuilder);

$dependencies = require $rootPath . '/bootstrap/container.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();

// Build PHP-DI Container instance
$container = $containerBuilder->build();

$application = new Application();
$application->add(new App\Command\CreateDB($container));

$application->run();

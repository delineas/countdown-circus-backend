<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

$containerBuilder = new ContainerBuilder();

$settings = require 'settings.php';
$settings($containerBuilder);

$dependencies = require 'container.php';
$dependencies($containerBuilder);

$container = $containerBuilder->build();
$app = AppFactory::createFromContainer($container);

require 'middlewares.php';
require 'web.php';



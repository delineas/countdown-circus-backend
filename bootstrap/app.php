<?php

use Slim\Factory\AppFactory;

require 'container.php';

$app = AppFactory::create();

require 'middlewares.php';
require 'web.php';


$app->run();
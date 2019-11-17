<?php

use DI\Container;
use Carbon\Carbon;
use Slim\Factory\AppFactory;

$container = new Container();
AppFactory::setContainer($container);

$container->set('carbon', function () {
    return new Carbon();
});



// End line
$app = AppFactory::create();
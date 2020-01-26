<?php

use App\Repository\CountdownRepository;
use App\Storage\SQLite;
use DI\Container;
use Carbon\Carbon;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        'carbon' => function () {
            return new Carbon();
        },
        'db' => function(ContainerInterface $container) {
            return SQLite::create($container->get('settings'));
        },
        'countdowns' => function(ContainerInterface $container) {
            return (new CountdownRepository($container->get('db')));
        }
    ]);
};
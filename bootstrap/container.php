<?php

use DI\Container;
use Carbon\Carbon;
use Slim\Factory\AppFactory;

$container = new Container();
AppFactory::setContainer($container);

$container->set('carbon', function () {
    return new Carbon();
});
$container->set('db', function() {
    try {
        return new \PDO("sqlite:database/db.sqlite");
    } catch (\PDOException $e) {
        var_dump('Error DB: ' . $e->getMessage());
        exit();
    }
    
});



// End line
$app = AppFactory::create();
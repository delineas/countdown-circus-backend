<?php

namespace App\Controllers;

use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

abstract class BaseController
{
    protected $app;
    public function __construct(ContainerInterface $container)
    {
        $this->app = $container;
    }

    public function jsonResponse(Response $response, $content)
    {
        $response->getBody()->write(json_encode($content));
        return $response
            ->withHeader('Content-Type', 'application/json');
    }
}
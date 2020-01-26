<?php 

namespace App\Controllers;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Psr\Container\ContainerInterface;

final class CountdownController extends BaseController
{

    public function list(Request $request, Response $response, $args) 
    {
        $results = $this->app->get('countdowns')->getAll();
        return $this->jsonResponse($response, $results);
    }


}
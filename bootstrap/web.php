<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/test', function (Request $request, Response $response, $args) {
    $response->getBody()->write($this->get('hello'));
    return $response;
});

$app->get('/api/countdowns', function (Request $request, Response $response, $args) {
    $data = [
        [
            'id' => 1,
            'name' => 'Boda de Carlos',
            'time_end' => $this->get('carbon')::now()->toString()
        ],
        [
            'id' => 2,
            'name' => 'Cumple del Taru',
            'time_end' => $this->get('carbon')::now()->toString()
        ]
    ];

    $payload = json_encode($data);
    $response->getBody()->write($payload);
    return $response
        ->withHeader('Content-Type', 'application/json');
});
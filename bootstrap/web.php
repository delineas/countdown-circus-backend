<?php

use Valitron\Validator;
use App\Controller\CountdownController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->get('/test', function (Request $request, Response $response, $args) {
    $response->getBody()->write($this->get('hello'));
    return $response;
});

$app->get('/api/countdowns', '\App\Controllers\CountdownController:list');

$app->get('/api/countdowns/{id}', function (Request $request, Response $response, $args) {

    $statement = $this->get('db')->prepare("SELECT * FROM countdowns WHERE id = :id");
    $statement->execute([
        ':id' => $args['id']
    ]);

    $results = [];
    while ($result = $statement->fetch(\PDO::FETCH_ASSOC)) {
        $result['date_diff'] = $this->get('carbon')::rawParse($result['date'])->diffInDays();
        $results[] = $result;
    }

    $response->getBody()->write(json_encode($results));
    return $response
        ->withHeader('Content-Type', 'application/json');
});

$app->post('/api/countdowns', function (Request $request, Response $response){

    $validator = new Validator($request->getParsedBody());
    $validator->rule('required', ['title', 'date']);
    $validator->rule('date', 'date')->message('Fecha no valida');
    $validator->rule('dateAfter', 'date', $this->get('carbon')::now())->message('La fecha tiene que ser posterior a la de hoy');
    
    if(!$validator->validate()) {
        $response->getBody()->write(json_encode([
            'errors' => $validator->errors()
        ]));
        return $response
            ->withStatus(422)
            ->withHeader('Content-Type', 'application/json');
    }

    $title = $request->getParsedBody()['title'];
    $date = $request->getParsedBody()['date'];

    $statement = $this->get('db')->prepare("INSERT INTO countdowns (title, date) VALUES (:title, :date)");
    $statement->execute([
        ':title' => $title,
        ':date' => $date
    ]);

    $response->getBody()->write(json_encode([
        'id' => $this->get('db')->lastInsertId()
    ]));
    return $response
        ->withStatus(200)
        ->withHeader('Content-Type', 'application/json');

});
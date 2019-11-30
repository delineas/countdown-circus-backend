<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/test', function (Request $request, Response $response, $args) {
    $response->getBody()->write($this->get('hello'));
    return $response;
});

$app->get('/api/countdowns', function (Request $request, Response $response, $args) {

    $statement = $this->get('db')->query("SELECT * FROM countdowns");

    $results = [];
    while($result = $statement->fetch(\PDO::FETCH_ASSOC)) {
        $result['date_diff'] = $this->get('carbon')::rawParse($result['date'])->diffInDays();
        $results[] = $result;
    }

    $response->getBody()->write(json_encode($results));
    return $response
        ->withHeader('Content-Type', 'application/json');
});

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
    $title = $request->getParsedBody()['title'];
    $date = $request->getParsedBody()['date'];

    if(strtotime($date) === FALSE) {
        return $response
            ->withStatus(400);
    }

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
<?php

namespace App\Repository;

use App\Storage\SQLite;

class CountdownRepository
{

    private $connection;
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function getAll()
    {
        $statement = $this->connection->query("SELECT * FROM countdowns");

        $results = [];
        while ($result = $statement->fetch(\PDO::FETCH_ASSOC)) {
            //$result['date_diff'] = $this->app->get('carbon')::rawParse($result['date'])->diffInDays();
            $results[] = $result;
        }

        return $results;
    }
}
<?php 

namespace App\Storage;

class SQLite
{

    private $config;
    public function __construct($config)
    {
        $this->config = $config;
    }

    static public function create($config)
    {
        return (new self($config))->connect();
    }

    public function connect()
    {
        try {
            return new \PDO($this->config['sqlite_path']); // sqlite:database/db.sqlite
        } catch (\PDOException $e) {
            var_dump('Error DB: ' . $e->getMessage());
            exit();
        }
    }

}
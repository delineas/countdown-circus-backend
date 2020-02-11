<?php 

namespace App\Command;

use DI\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDB extends Command
{
    private $db;

    public function __construct(Container $container)
    {
        parent::__construct();
        $this->db = $container->get('db');
        $this->settings = $container->get('settings');
    }

    protected function configure()
    {
        $this
            ->setName('app:start-db')
            ->setDescription('Initialize database');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {

        if(!file_exists($this->settings['sqlite_path'])) {
            shell_exec('touch ' . str_replace('sqlite:', '', $this->settings['sqlite_path']));
        }

        $pdo = $this->db;

        $query = 
            "CREATE TABLE countdowns_test (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title text NOT NULL,
            date text NOT NULL
            )";

        $pdo->exec($query);

        $output->writeLn("Database structure created");

        return 1;
    }
}
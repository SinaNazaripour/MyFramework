<?php
include __DIR__ . "/src/Framework/Database.php";
require __DIR__ . "/vendor/autoload.php";

use App\Config\Paths;
use Framework\Container;
use Framework\Database;

// $definitions = include Paths::SOURCE . "/App/container-definitions.php";
// // $container = new Container();
// $container->addDefinitions($definitions);
// $db = $container->resolve(Database::class);

// $query = file_get_contents("./database.sql");

// $db->query($query);
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load();

$db = new Database(
    driver: $_ENV['DB_DRIVER'],
    config: [
        "host" => $_ENV['DB_HOST'],
        "port" => $_ENV['DB_PORT'],
        "dbname" => $_ENV['DB_NAME']
    ],
    username: $_ENV['DB_USER'],
    password: $_ENV['DB_PASS']
);
$query = file_get_contents('./database.sql');
$db->query($query);

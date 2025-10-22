<?php
$driver = "mysql";
$config = http_build_query(
    data: [
        "host" => "localhost",
        "port" => 3306,
        "dbname" => "myframework",


    ],
    arg_separator: ";"
);

$dsn = "{$driver}:{$config}";
$username = "root";
$password = "";
try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $th) {
    die("unable to connect");
}


echo "Connected To Database.";

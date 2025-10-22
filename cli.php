<?php
include __DIR__ . "/src/Framework/Database.php";

use Framework\Database;
// $driver = "mysql";
// $config = http_build_query(
//     data: [
//         "host" => "localhost",
//         "port" => 3306,
//         "dbname" => "myframework",


//     ],
//     arg_separator: ";"
// );

// $dsn = "{$driver}:{$config}";
// $username = "root";
// $password = "";
// // to be safe ------
// try {
//     
// } catch (PDOException $th) {
//     die("unable to connect");
// }
// -----------------------
$db = new Database(
    driver: "mysql",
    config: [
        "host" => "localhost",
        "port" => 3306,
        "dbname" => "myframework"
    ],
    username: "root",
    password: ""
);
echo "Connected To Database.";

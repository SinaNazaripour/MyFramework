<?php
echo "hello to my first PHP project\n ";
$app=include __DIR__."/../src/App/bootstrap.php";

$app->run();
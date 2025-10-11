<?php
declare(strict_types=1);

function dd($a){
    echo "<pre>";
    var_dump($a);
    echo"</pre>";
    die();
}
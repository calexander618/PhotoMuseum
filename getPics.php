<?php

    $string = file_get_contents('ImageLibrary.json');
    $json = json_decode($string, true);

    $genre = $_GET["genre"];

    for ($i = 0; $i < 10; $i++) {
        echo $json[$genre][$i]['filename'];
        echo "\n";
    }

    echo $json[$genre . 'info']['description'];
    echo "\n";

?>
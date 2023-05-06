<?php

require __DIR__.'/config.php';

if(isset($_GET['regenerate'])){
    $files = glob(__DIR__.'/cache/*');
    foreach ($files as $file){
        unlink($file);
    }

    \Pschur\Assets\Asset::optimize();
    header('location: '.($_GET['back'] ?? '/'));
    exit();
}

echo \Pschur\Assets\Asset::getAsset();
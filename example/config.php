<?php

use Pschur\Assets\Asset;

require __DIR__.'/../vendor/autoload.php';
Asset::setAutoOptimize(true);
Asset::setAssetCache(__DIR__.'/cache');
Asset::setAssetUrl('/assets.php');

Asset::css(__DIR__.'/picocss.css');
Asset::css('a {color: green}');

Asset::js(__DIR__.'/demo.js');
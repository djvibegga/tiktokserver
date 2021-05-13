<?php

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

use TikTok\Scanner\Server;
use TikTok\Scanner\Scanner;
use TikTok\CacheEngine;

$httpIp = isset($argv[1]) ? (string)$argv[1] : '127.0.0.1';
$httpPort = isset($argv[2]) ? (int)$argv[2] : 80;

$cacheEngine = new CacheEngine([
    ['127.0.0.1', 11211, 100],
]);

$api = new Sovit\TikTok\Api(
    [
        'cache-timeout' => 180
    ],
    $cacheEngine
);
$scanner = new Scanner($api);

$server = new Server($scanner, $httpIp, $httpPort);
$server->start();

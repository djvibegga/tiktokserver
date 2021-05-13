<?php

require_once __DIR__ . '/library/tiktok/lib/TikTok/Helper.php';
require_once __DIR__ . '/library/tiktok/lib/TikTok/Api.php';
require_once __DIR__ . '/library/tiktok/lib/TikTok/Download.php';

$api = new Sovit\TikTok\Api();
// $response = $api->getUserFeed('yujiinm');
// var_dump($response->items);
// exit;

// $response = $api->getUserFeed('mamkin_simpotiaga', 1591427805000);
$response = $api->getVideoByID(6836683604592971013);
var_dump($response->items[0]->video); exit;

// $downloader = new Sovit\TikTok\Download();
// header('Content-type: video/mp4');
// $downloader->url($response->items[0]->video->downloadAddr, "video-file", 'mp4');

// $streamer = new Sovit\TikTok\Stream();
// $streamer->stream($result->items[0]->video->playAddr);

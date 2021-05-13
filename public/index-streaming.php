<?php

require_once __DIR__ . '/library/tiktok/lib/TikTok/Helper.php';
require_once __DIR__ . '/library/tiktok/lib/TikTok/Api.php';
require_once __DIR__ . '/library/tiktok/lib/TikTok/Stream.php';

$api = new Sovit\TikTok\Api();

$response = $api->getVideoByID(6836683604592971013);

$streamer = new Sovit\TikTok\Stream();
$streamer->stream($response->items[0]->video->playAddr);
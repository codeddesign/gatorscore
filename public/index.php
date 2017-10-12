<?php

require_once '../vendor/autoload.php';

// config: check
if (!trim(GATORIO_ACCESS_TOKEN)) {
    exit('Access token is missing from config.'.PHP_EOL);
}

// request: initiate
$request = Symfony\Component\HttpFoundation\Request::createFromGlobals();

// gator: initiate
$gator = new Gator\Gator(GATORIO_ACCESS_TOKEN);

// gator: fetch score response
$response = $gator->score(
    $request->server->get('REMOTE_ADDR') ?? '',
    $request->headers->get('User-Agent') ?? '',
    $request->server->get('HTTP_REFERER') ?? '',
    $request->get('referrer') ?? ''
);

// gator: validate score
header('Content-Type: application/json', false);
echo json_encode(['score' => $response->data->score ?? 0]);

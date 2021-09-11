<?php
require './vendor/autoload.php';
require './public/index.php';

$grpc = new \Mix\Grpc\Server();
$grpc->register(\User\Services\UserGrpcService::class);

Swoole\Coroutine\run(function () use ($grpc) {
    $server = new Swoole\Coroutine\Http\Server('0.0.0.0', 9595, false);
    $server->handle('/', $grpc->handler());
    $server->set([
        'open_http2_protocol' => true,
        'http_compression' => false,
    ]);
    $server->start();
});

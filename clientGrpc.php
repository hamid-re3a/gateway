<?php
require './vendor/autoload.php';


$client = new \User\Services\UserServiceClient('127.0.0.1:9595', [
    'credentials' => \Grpc\ChannelCredentials::createInsecure()
]);
$request = new \User\Services\Id();
$request->setId((int)1);


list($reply, $status) = $client->getUserById($request)->wait();

print_r($status->code);
//print_r($reply);
//$getdata = $reply->getGetdataarr();

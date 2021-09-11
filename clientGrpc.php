<?php
require './vendor/autoload.php';


$client = new \User\Services\UserServiceClient('127.0.0.1:9595', [
    'credentials' => \Grpc\ChannelCredentials::createInsecure()
]);
$request = new \User\Services\Id();
$request->setId((int)3);


list($reply, $status) = $client->getUserById($request)->wait();

print_r($status);
print_r($reply->getFirstName());
$getdata = $reply->getGetdataarr();

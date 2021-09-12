<?php
require './vendor/autoload.php';


$client = new \User\Services\UserServiceClient('staging-api-gateway.janex.org:9595', [
    'credentials' => \Grpc\ChannelCredentials::createInsecure()
]);
$request = new \User\Services\Id();
$request->setId((int)1);


list($reply, $status) = $client->getUserById($request)->wait();

//print_r($status);
print_r($reply->getFirstName());
//$getdata = $reply->getGetdataarr();

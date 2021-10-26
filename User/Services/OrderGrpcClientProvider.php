<?php

namespace User\Services;


use Orders\Services\Grpc\Acknowledge;
use Orders\Services\Grpc\Order;

class OrderGrpcClientProvider
{
    protected static $client;

    public function __construct()
    {
        self::$client = getOrderGrpcClient();
    }

    public static function sponsorPackage(Order $order) : Acknowledge
    {
        /** @var $submit_response Acknowledge */
        list($submit_response, $flag) = self::$client->sponsorPackage($order)->wait();
        if ($flag->code != 0)
            throw new \Exception('Order not responding', 406);
        return $submit_response;
    }

}

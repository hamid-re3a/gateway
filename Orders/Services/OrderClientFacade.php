<?php


namespace Order\Services;


use Illuminate\Support\Facades\Facade;
use Orders\Services\Grpc\Acknowledge;
use Orders\Services\Grpc\Order;

/**
 * @method static Acknowledge sponsorPackage(Order $order)
 */

class OrderClientFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return __CLASS__;
    }

    public static function shouldProxyTo($class)
    {
        return app()->singleton(self::getFacadeAccessor(),$class);
    }
}

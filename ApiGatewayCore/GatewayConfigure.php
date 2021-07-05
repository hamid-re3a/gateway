<?php

namespace ApiGatewayCore;

class GatewayConfigure
{

    public static $runsMigrations = true;


    public static function ignoreMigrations(): self
    {
        static::$runsMigrations = false;

        return new static;
    }
}

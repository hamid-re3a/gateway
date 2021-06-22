<?php

namespace R2FUser;

class UserConfigure
{

    public static $runsMigrations = true;


    public static function ignoreMigrations(): self
    {
        static::$runsMigrations = false;

        return new static;
    }
}

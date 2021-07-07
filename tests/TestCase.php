<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->app->setLocale('en');
        $this->artisan('db:seed');
        $this->artisan('db:seed', ['--class' => "User\database\seeders\AuthTableSeeder"]);
    }

    public function hasMethod($class, $method): void
    {
        $this->assertTrue(
            method_exists($class, $method),
            "$class must have method $method"
        );
    }
}

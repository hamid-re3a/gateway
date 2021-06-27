<?php

namespace Tests;

use R2FUser\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Spatie\Permission\Models\Role;

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
    }

    public function hasMethod($class, $method): void
    {
        $this->assertTrue(
            method_exists($class, $method),
            "$class must have method $method"
        );
    }
}

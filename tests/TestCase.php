<?php

namespace Tests;

use App\Models\User;
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

        $user = User::factory()->create();
        Role::create([
            'name'=>'admin',
            'guard_name'=>'api'
        ]);
        Role::create([
            'name'=>'client',
            'guard_name'=>'api'
        ]);

    }

    public function hasMethod($class, $method): void
    {
        $this->assertTrue(
            method_exists($class, $method),
            "$class must have method $method"
        );
    }
}

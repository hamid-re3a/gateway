<?php


namespace User\tests;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use User\UserConfigure;
use Tests\CreatesApplication;

class UserTest extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->app->setLocale('en');
        UserConfigure::seed();
    }

    public function hasMethod($class, $method)
    {
        $this->assertTrue(
            method_exists($class, $method),
            "$class must have method $method"
        );
    }

    /**
     * @test
     */
    public function assert_true_test()
    {
        $this->assertTrue(true);
    }
}

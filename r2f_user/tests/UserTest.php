<?php


namespace R2FUser\tests;


use Illuminate\Support\Facades\Mail;
use R2FUser\Mail\User\WelcomeEmail;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * @test
     */
    public function register_new_user_green()
    {
        Mail::fake();
        $response = $this->post(route('auth.register'), [
            "first_name" => 'hamid',
            "last_name" => 'noruzi',
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "username" => 'hamid',
            "password" => '123456789!Q',
            "password_confirmation" => '123456789!Q',
        ]);
        $response->assertOk();
        Mail::assertSent(WelcomeEmail::class);
    }

    /**
     * @test
     */
    public function register_new_user_not_enough_strong_password()
    {
        Mail::fake();
        $response = $this->post(route('auth.register'), [
            "first_name" => 'hamid',
            "last_name" => 'noruzi',
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "username" => 'hamid',
            "password" => '123',
            "password_confirmation" => '123',
        ]);
        $response->assertStatus(302);
        Mail::assertNotSent(WelcomeEmail::class);
    }
}

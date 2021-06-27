<?php


namespace R2FUser\tests;


use Illuminate\Support\Facades\Mail;
use R2FUser\Mail\User\EmailVerifyOtp;
use R2FUser\Mail\User\ForgetPasswordOtpEmail;
use R2FUser\Mail\User\SuccessfulEmailVerificationEmail;
use R2FUser\Mail\User\WelcomeEmail;
use R2FUser\Models\User;
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


    /**
     * @test
     */
    public function login_when_user_has_not_activate_its_account()
    {
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $response = $this->post(route('auth.login'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password',
        ]);
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function login_user_green()
    {
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $user->email_verified_at = now();
        $user->save();
        $response = $this->post(route('auth.login'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password',
        ]);
        $response->assertOk();
    }

    /**
     * @test
     */
    public function ask_for_email_otp_green()
    {
        Mail::fake();
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $response = $this->post(route('auth.ask-for-email-otp'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        $response->assertOk();
        Mail::assertSent(EmailVerifyOtp::class);
    }
}

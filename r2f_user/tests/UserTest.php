<?php


namespace R2FUser\tests;


use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use R2FUser\Mail\User\EmailVerifyOtp;
use R2FUser\Mail\User\ForgetPasswordOtpEmail;
use R2FUser\Mail\User\TooManyLoginAttemptPermanentBlockedEmail;
use R2FUser\Mail\User\TooManyLoginAttemptTemporaryBlockedEmail;
use R2FUser\Mail\User\WelcomeEmail;
use R2FUser\Models\LoginAttempt;
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
    public function login_user_block()
    {
        Mail::fake();
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $user->email_verified_at = now();
        $user->save();
        list($intervals, $tries) = getLoginAttemptSetting();
        foreach ($intervals as $key => $interval) {
            for ($i = 0; $i <= $tries[$key]; $i++) {

                $response = $this->post(route('auth.login'), [
                    "email" => 'hamidrezanoruzinejad@gmail.com',
                    "password" => 'incorrect password',
                ]);
            }
            Carbon::setTestNow(now()->addSeconds($interval));
            Mail::assertSent(TooManyLoginAttemptTemporaryBlockedEmail::class);

        }
        Mail::assertSent(TooManyLoginAttemptPermanentBlockedEmail::class);
        $user->refresh();
        $this->assertEquals(USER_BLOCK_TYPE_AUTOMATIC, $user->block_type);
    }

    /**
     * @test
     */
    public function user_forgot_password_green()
    {
        Mail::fake();
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $user->email_verified_at = now();
        $user->save();
        $response = $this->post(route('auth.forgot-password'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        Mail::assertSent(ForgetPasswordOtpEmail::class);
    }

    /**
     * @test
     */
    public function user_forgot_password_failed()
    {
        Mail::fake();
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $user->email_verified_at = now();
        $user->save();
        $response = $this->post(route('auth.forgot-password'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        $response = $this->post(route('auth.forgot-password'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        $this->assertEquals(429,$response->status());
    }
    /**
     * @test
     */
    public function user_email_verify_green()
    {
        Mail::fake();
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password',
            "email_verified_at" => null
        ]);
        $response = $this->post(route('auth.ask-for-email-otp'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        Mail::assertSent(EmailVerifyOtp::class);
    }

    /**
     * @test
     */
    public function user_email_verify_failed()
    {
        Mail::fake();
        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $response = $this->post(route('auth.ask-for-email-otp'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        $response = $this->post(route('auth.ask-for-email-otp'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        $this->assertEquals(429,$response->status());
    }
    /**
     * @test
     */
    public function login_user_block_failed()
    {
        Mail::fake();

        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);

        $user->email_verified_at = now();
        $user->save();

        list($intervals, $tries) = getLoginAttemptSetting();
        for ($i = 0; $i <= $tries[0] + 3; $i++) {
            $response = $this->post(route('auth.login'), [
                "email" => 'hamidrezanoruzinejad@gmail.com',
                "password" => 'incorrect password',
            ]);
        }

        Mail::assertSent(TooManyLoginAttemptTemporaryBlockedEmail::class);
        $this->assertEquals(trans('responses.max-attempts-exceeded'), $response->json()['message']);

        $user->refresh();
        $this->assertNotEquals(USER_BLOCK_TYPE_AUTOMATIC, $user->block_type);
        $this->assertEquals(null, $user->block_type);
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

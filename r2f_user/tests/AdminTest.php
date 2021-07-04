<?php


namespace R2FUser\tests;


use Illuminate\Support\Facades\Mail;
use R2FUser\Mail\User\SuccessfulEmailVerificationEmail;
use R2FUser\Mail\User\UserAccountActivatedEmail;
use R2FUser\Models\User;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * @test
     */
    public function verify_email_user_account_green()
    {
        Mail::fake();
        $admin = User::find(1);
        $this->actingAs($admin);

        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $response = $this->post(route('admin.verify-email-user-account'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
        ]);
        $response->assertOk();
        Mail::assertSent(SuccessfulEmailVerificationEmail::class);
    }

    /**
     * @test
     */
    public function user_deactivate_activate()
    {
        Mail::fake();
        $admin = User::find(1);
        $this->actingAs($admin);

        $user = User::factory()->create([
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "password" => 'password'
        ]);
        $response = $this->post(route('admin.activate-or-deactivate-user-account'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "deactivate" => true
        ]);
        $response->assertOk();
        Mail::assertSent(UserAccountActivatedEmail::class);

        $user->refresh();
        $this->assertEquals(USER_BLOCK_TYPE_BY_ADMIN,$user->block_type);
        $response = $this->post(route('admin.activate-or-deactivate-user-account'), [
            "email" => 'hamidrezanoruzinejad@gmail.com',
            "deactivate" => false
        ]);
        $response->assertOk();
        Mail::assertSent(UserAccountActivatedEmail::class);

        $user->refresh();
        $this->assertEquals(null,$user->block_type);
    }

}
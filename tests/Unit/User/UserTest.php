<?php

namespace Tests\Unit\User;

use App\Models\Order;
use App\Models\ReferralTree;
use R2FUser\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{

    /**
     * @test
     */
    public function it_should_have_national_code()
    {
        $user = User::factory()->create();
        $this->assertNotNull($user->email);
    }


}

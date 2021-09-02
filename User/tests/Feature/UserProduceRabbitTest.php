<?php

namespace User\tests\Feature;

use App\Jobs\User\UserDataJob;
use User\Services\User;
use User\tests\UserTest;

class UserProduceRabbitTest extends UserTest
{
    /**
     * @test
     */
    public function update_exist_user_produce_change_rabbit()
    {
        $user = new User();
        $user->setId(1);
        $user->setEmail("d@d.com");
        $user->setFirstName("RabbitNameTest1");
        $user->setLastName("RabbitFamilyTest1");
        $user->setUsername("Rabbit1");
        $user->setRole('test2,test4,test7');
        $serializeUser = serialize($user);
        UserDataJob::dispatch($serializeUser)->onConnection('rabbit')->onQueue('subscriptions');
        UserDataJob::dispatch($serializeUser)->onConnection('rabbit')->onQueue('kyc');
        $this->assertTrue(true);
    }
}

<?php

namespace User\database\seeders;

use User\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

/**
 * Class AuthTableSeeder.
 */
class AuthTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (USER_ROLES as $role) {
            Role::query()->firstOrCreate(['name' => $role]);
        }

        if (!User::query()->where('email', 'admin@yopmail.com')->exists()) {
            $admin = User::whereUsername('admin')->first();
            if(!$admin){
                $admin = User::factory()->create([
                    'username' => 'admin',
                ]);
                $admin->password = 'password123';
                $admin->member_id = 1000;
                $admin->transaction_password = 'PA$$W0RD';
                $admin->first_name = 'admin';
                $admin->last_name = 'admin';
                $admin->email_verified_at = now();
            }

            $admin->email = 'work@sajidjaved.com';
            $admin->save();

            $admin->assignRole([USER_ROLE_SUPER_ADMIN,USER_ROLE_CLIENT]);
        }
        if (!User::query()->where('email', 'janexstaging@gmail.com')->exists()) {
            $global = User::whereUsername('johny')->first();
            if(!$global){
                $global = User::factory()->create([
                    'username' => 'johny',
                ]);
                $global->update([
                    'member_id' => '2000',
                    'email' => 'janexstaging@gmail.com',
                    'password' => 'password',
                    'transaction_password' => 'password',
                    'first_name' => 'John',
                    'last_name' => 'Due',
                    'sponsor_id' => 1,
                    'username' => 'johny',
                    'email_verified_at' => now()
                ]);
            }

            $global->assignRole([USER_ROLE_SUPER_ADMIN,USER_ROLE_CLIENT]);
        }
        if (!User::query()->where('email', 'customer@yopmail.com')->exists()) {
            $global = User::whereUsername('johny')->first();
            if(!$global){
                $global = User::factory()->create([
                    'username' => 'George',
                ]);
                $global->update([
                    'member_id' => '3000',
                    'email' => 'customer@yopmail.com',
                    'password' => 'password',
                    'transaction_password' => 'password',
                    'first_name' => 'George',
                    'last_name' => 'W Father',
                    'sponsor_id' => 1,
                    'username' => 'George',
                    'email_verified_at' => now()
                ]);
            }

            $global->assignRole([USER_ROLE_CLIENT]);
        }

    }
}

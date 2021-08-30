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

        if (!User::query()->where('email', 'work@sajidjaved.com')->exists()) {
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

            $admin->email = 'admin@site.com';
            $admin->save();
            $admin->assignRole(USER_ROLE_ADMIN);
        }

    }
}

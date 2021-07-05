<?php

namespace ApiGatewayUser\database\seeders;

use ApiGatewayUser\Models\User;
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

        if (!User::query()->where('email', 'admin@r2f.com')->exists()) {
            $admin = User::query()->firstOrCreate([
                'email' => 'admin@r2f.com',
                'first_name' => 'admin',
                'username' => 'admin',
                'last_name' => 'admin',
                'password' => 'password',
                'email_verified_at' => now(),
            ]);

            $admin->assignRole(USER_ROLE_ADMIN);
        }
    }
}

<?php


namespace Database\Seeders\Auth;

use App\Models\ReferralTree;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        // Create Roles
        foreach (USER_ROLES as $role) {
            Role::query()->firstOrCreate(['name' => $role]);
        }

        if (!User::query()->where('email', 'admin@r2f.com')->exists()) {
            $admin = User::query()->firstOrCreate([
                'email' => 'admin@r2f.com',
                'first_name' => 'admin',
                'last_name' => 'admin',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            ]);
            $admin->assignRole(USER_ROLE_ADMIN);
        }
    }
}

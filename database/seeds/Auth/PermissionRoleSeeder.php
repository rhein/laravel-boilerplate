<?php

use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\Role;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();

        // Create Roles
        Role::create([
            'id' => 1,
            'name' => 'Administrator',
        ]);

        Role::create([
            'id' => config('boilerplate.access.role.default'),
            'name' => 'Member',
        ]);

        // Non Grouped Permissions
        Permission::create([
            'name' => 'view backend',
            'description' => 'Access Administration',
        ]);

        // Grouped permissions
        // Users category
        $users = Permission::create([
            'name' => 'access.user',
            'description' => 'All User Permissions',
        ]);

        $users->children()->saveMany([
            new Permission([
                'name' => 'access.user.list',
                'description' => 'View Users',
            ]),
            new Permission([
                'name' => 'access.user.deactivate',
                'description' => 'Deactivate Users',
                'sort' => 2,
            ]),
            new Permission([
                'name' => 'access.user.reactivate',
                'description' => 'Reactivate Users',
                'sort' => 3,
            ]),
            new Permission([
                'name' => 'access.user.clear-session',
                'description' => 'Clear User Sessions',
                'sort' => 4,
            ]),
            new Permission([
                'name' => 'access.user.impersonate',
                'description' => 'Impersonate Users',
                'sort' => 5,
            ]),
            new Permission([
                'name' => 'access.user.change-password',
                'description' => 'Change User Passwords',
                'sort' => 6,
            ]),
        ]);

        // Assign Permissions to other Roles
        // Note: Admin (User 1) Has all permissions via a gate in the AuthServiceProvider
        // $user->givePermissionTo('view backend');

        $this->enableForeignKeys();
    }
}

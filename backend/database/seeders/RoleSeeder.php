<?php

namespace Database\Seeders;

use App\Admin\Domain\Models\Permission;
use App\Admin\Domain\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::where('guard_name', 'admin')->pluck('id');
        $role = Role::firstOrCreate(
            [
                'name' => 'super admin',
                'guard_name' => 'admin',
            ], [
                'name' => 'super admin',
                'guard_name' => 'admin',
                'en' => ['display_name' => 'super admin'],
                'ar' => ['display_name' => 'super admin'],
            ]);
        $role->givePermissionTo($permissions);
    }
}

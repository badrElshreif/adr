<?php

namespace Database\Seeders;

use App\Admin\Domain\Models\Permission;
use App\Admin\Domain\Models\Role;
use Illuminate\Database\Seeder;

class CompanyPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crudPermissionNames = [
            'offices' => 'مكاتب', 'roles' => 'الأدوار والصلاحيات', 'admins' => 'المسؤولين', 'employees' => 'الموظفين', 'library' => 'المكتبة', 'calendar' => 'التقويم', 'reports' => 'التقارير', 'packages' => 'الباقات'
        ];

        $crudActions = ['index' => 'تصفح', 'create' => 'إضافة', 'update' => 'تعديل', 'delete' => 'حذف'];

        $permissions = [

        ];

        foreach ($permissions as $permission)
        {
            Permission::updateOrCreate(
                [
                    'name'       => $permission['name'],
                    'key'        => $permission['key'],
                    'guard_name' => 'company'
                ],
                [
                    'en' => $permission['en'],
                    'ar' => $permission['ar']
                ]
            );
        }

        foreach ($crudPermissionNames as $en_permission => $ar_permission)
        {

            foreach ($crudActions as $en_action => $ar_action)
            {
                Permission::updateOrCreate(
                    [
                        'name'       => $en_permission . '.' . $en_action,
                        'key'        => $en_permission,
                        'guard_name' => 'company'
                    ],
                    [
                        'en' => ['display_name' => $en_action . ' ' . $en_permission, 'key_name' => $en_permission],
                        'ar' => ['display_name' => $ar_action . ' ' . $ar_permission, 'key_name' => $ar_permission]
                    ]
                );
            }

        }

        $permissions = Permission::where('guard_name', 'company')->pluck('id');
        $role        = Role::firstOrCreate(
            [
                'name'       => 'super admin',
                'guard_name' => 'company'
            ], [
                'name'       => 'super admin',
                'guard_name' => 'company',
                'en'         => ['display_name' => 'super admin'],
                'ar'         => ['display_name' => 'المدير العام']
            ]);
        $role->givePermissionTo($permissions);

    }

}

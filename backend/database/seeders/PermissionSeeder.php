<?php

namespace Database\Seeders;

use App\Admin\Domain\Models\Permission;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crudPermissionNames = ['admins' => 'المدراء', 'roles'       => 'الأدوار والصلاحيات', 'users' => 'المستخدمين', 'notifications' => 'الإشعارات', 'rooms'          => 'الغرف', 'packages' => 'الباقات',
            'focus-packages'                 => 'باقات التركيز', 'files' => 'الملفات', 'pages'            => 'الصفحات', 'faqs'             => 'الأسئلة الشائعة', 'settings' => 'الاعدادات'
        ];

        $crudActions = ['index' => 'تصفح', 'create' => 'إضافة', 'update' => 'تعديل', 'delete' => 'حذف'];

        $permissions = [
            [
                'name'       => 'statistics.index',
                'key'        => 'statistics',
                'guard_name' => 'admin',
                'en'         => ['display_name' => 'statistics.index', 'key_name' => 'statistics', 'key_name' => 'Statistics'],
                'ar'         => ['display_name' => 'تصفح الاحصائيات', 'key_name' => 'الاحصائيات', 'key_name' => 'الإحصائيات']
            ], [
                'name'       => 'contact_us.index',
                'key'        => 'contact_us',
                'guard_name' => 'admin',
                'en'         => ['display_name' => 'contact_us.index', 'key_name' => 'contact_us', 'key_name' => 'contact_us'],
                'ar'         => ['display_name' => 'اتصل بنا', 'key_name' => 'اتصل بنا', 'key_name' => 'اتصل بنا']
            ]
        ];

        foreach ($permissions as $permission)
        {
            Permission::updateOrCreate(
                [
                    'name'       => $permission['name'],
                    'key'        => $permission['key'],
                    'guard_name' => 'admin'
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
                        'guard_name' => 'admin'
                    ],
                    [
                        'en' => ['display_name' => $en_action . ' ' . $en_permission, 'key_name' => $en_permission],
                        'ar' => ['display_name' => $ar_action . ' ' . $ar_permission, 'key_name' => $ar_permission]
                    ]
                );
            }

        }

        $role = Role::where('name', 'super admin')->where('guard_name', 'admin')->first();
        $role->givePermissionTo(Permission::where('guard_name', 'admin')->get());

    }

}

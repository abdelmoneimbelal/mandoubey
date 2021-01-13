<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'التقارير',
            'تقرير الفواتير',
            'تقرير العملاء',
            
            'المشرفين',
            'اضافة مشرف',
            'تعديل مشرف',
            'حذف مشرف',
            'قائمة المشرفين',
            'صلاحيات المشرفين',

            'المستخدمين',
            'حذف مستخدم',
            'عرض مستخدم',
            'قائمة العملاء',
            'قائمة المندوبين',

            'الاقسام',
            'اضافة قسم',
            'تعديل قسم',
            'حذف قسم',

            'المحافظات',
            'اضافة محافظه',
            'تعديل  محافظه',
            'حذف محافظه',

            'المدن',
            'اضافة مدينه',
            'تعديل مدينه',
            'حذف مدينه',

            'طرق التوصيل',
            'اضافه طريقة',
            'تعديل طريقة',
            'حذف طريقة',
            'عرض طريقة',

            'تصدير EXCEL',

            'عرض صلاحية',
            'اضافة صلاحية',
            'تعديل صلاحية',
            'حذف صلاحية',

            'الاشعارات',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
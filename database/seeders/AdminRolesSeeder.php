<?php

namespace Database\Seeders;

use App\Models\AdminRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRoles = [
            [
                'admin_id'=>'670a90ec369a9c78700847c2',
                'module'=>'cms_pages',
                'view_access'=>1,
                'edit_access'=>1,
                'full_access'=>1
            ],
            [
                'admin_id'=>'670d0d08626b9f54d60c9c22',
                'module'=>'cms_pages',
                'view_access'=>1,
                'edit_access'=>1,
                'full_access'=>1
            ],
        ];
        AdminRole::create($adminRoles);
//        foreach ($adminRoles as $role){
//            AdminRole::create($role);
//        }

    }
}

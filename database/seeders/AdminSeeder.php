<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Admin::create([
//           'name'=>'Admin_1',
//           'type'=>'admin',
//           'status'=>1,
//           'password'=>Hash::make('12345678'),
//           'image'=>'',
//           'email'=>'admin@admin1.com',
//            'mobile'=>'014092323123'
//        ]);
        $password = Hash::make('12345678');
        $subAdmins = [
            [    'name'=>'ashraf',
                'type'=>'subadmin',
                'status'=>1,
                'password'=>$password,
                'image'=>'',
                'email'=>'ashraf@gmail.com',
                'mobile'=>'014092323000'
            ],
            [
                'name'=>'arif',
                'type'=>'subadmin',
                'status'=>1,
                'password'=>$password,
                'image'=>'',
                'email'=>'arif@gmail.com',
                'mobile'=>'014092323999'
            ],
            [
                'name'=>'atik',
                'type'=>'subadmin',
                'status'=>1,
                'password'=>$password,
                'image'=>'',
                'email'=>'atik@gmail.com',
                'mobile'=>'014092000999'
            ],

        ];
        foreach ($subAdmins as $subAdmin){
            Admin::create($subAdmin);
        }
    }
}

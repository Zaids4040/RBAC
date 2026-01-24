<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'Zaid';
        $user->email = 'zaids4010@gmail.com';
        $user->phone = '+923158580252';
        $user->role_id = 1;
        $user->salary_type = 1;
        $user->paid_leaves_monthly = 1;
        $user->password = 'zaid1234';
        $user->salary = 1000;
        $user->save();
    }
}

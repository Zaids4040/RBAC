<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert(
            [
                [
                    'module'=>'admin_dashboard',
                    'action'=>'Full Access',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'user_dashboard',
                    'action'=>'Full Access',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'create',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'edit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'delete',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'view',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'create_high',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'edit_high',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'delete_high',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'users',
                    'action'=>'view_high',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'roles',
                    'action'=>'create',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'roles',
                    'action'=>'edit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'roles',
                    'action'=>'delete',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'roles',
                    'action'=>'view',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'packages',
                    'action'=>'create',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'packages',
                    'action'=>'edit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'packages',
                    'action'=>'delete',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'packages',
                    'action'=>'view',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'module'=>'leads',
                    'action'=>'create',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'leads',
                    'action'=>'edit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'leads',
                    'action'=>'delete',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'leads',
                    'action'=>'view',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'module'=>'attendence',
                    'action'=>'create',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'attendence',
                    'action'=>'edit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'attendence',
                    'action'=>'delete',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'attendence',
                    'action'=>'view',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'module'=>'accounts',
                    'action'=>'create',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'accounts',
                    'action'=>'edit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'accounts',
                    'action'=>'delete',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'accounts',
                    'action'=>'view',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],

                [
                    'module'=>'emailconfig',
                    'action'=>'create',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'emailconfig',
                    'action'=>'edit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'emailconfig',
                    'action'=>'delete',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'module'=>'emailconfig',
                    'action'=>'view',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                
                
                
            ]
        );
    }
}

<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;


class RoleSeeder extends Seeder
{
    
    public function run(): void
    {
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'admin.users']);
        Role::create(['name'=>'admin.products']);
        Role::create(['name'=>'admin.orders']);
        Role::create(['name'=>'admin.factures']);
        Role::create(['name'=>'admin.opportunities']);
        Role::create(['name'=>'admin.categories']);
        Role::create(['name'=>'admin.roles']);
        Role::create(['name'=>'customer']);
        Role::create(['name'=>'seler']);
        Role::create(['name'=>'default']);

    }
}


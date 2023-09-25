<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name'=>'admin']);
        Role::create(['name'=>'admin.customer']);
        Role::create(['name'=>'admin.product']);
        Role::create(['name'=>'admin.order']);
        Role::create(['name'=>'admin.facture']);
        Role::create(['name'=>'admin.opportunity']);
        Role::create(['name'=>'admin.category']);
        Role::create(['name'=>'default']);

    }
}

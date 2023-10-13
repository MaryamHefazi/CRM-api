<?php

namespace Database\Seeders;

use Faker\Provider\ar_EG\Person;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name'=>'users.*']);
        Permission::create(['name'=>'products.*']);
        Permission::create(['name'=>'orders.*']);
        Permission::create(['name'=>'factures.*']);
        Permission::create(['name'=>'opportunities.*']);
        Permission::create(['name'=>'categories.*']);
        Permission::create(['name' => 'roles.*']);

        Permission::create(['name' => 'users.all']);
        Permission::create(['name' => 'users.all.user']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.store']);
        Permission::create(['name' => 'users.update']);
        Permission::create(['name' => 'users.update.user']);
        Permission::create(['name' => 'users.delete']);
        Permission::create(['name' => 'users.delete.user']);

        Permission::create(['name' => 'products.all']);
        Permission::create(['name' => 'products.show']);
        Permission::create(['name' => 'products.store']);
        Permission::create(['name' => 'products.store.seler']);
        Permission::create(['name' => 'products.update']);
        Permission::create(['name' => 'products.update.seler']);
        Permission::create(['name' => 'products.delete']);
        Permission::create(['name' => 'products.delete.seler']);

        Permission::create(['name' => 'orders.all']);
        Permission::create(['name' => 'orders.all.user']);
        Permission::create(['name' => 'orders.show']);
        Permission::create(['name' => 'orders.store']);
        Permission::create(['name' => 'orders.store.user']);
        Permission::create(['name' => 'orders.update']);
        Permission::create(['name' => 'orders.delete']);

        Permission::create(['name' => 'factures.all']);
        Permission::create(['name' => 'factures.all.user']);
        Permission::create(['name' => 'factures.show']);
        Permission::create(['name' => 'factures.store']);
        Permission::create(['name' => 'factures.update']);
        Permission::create(['name' => 'factures.delete']);

        Permission::create(['name' => 'opportunities.all']);
        Permission::create(['name' => 'opportunities.all.user']);
        Permission::create(['name' => 'opportunities.show']);
        Permission::create(['name' => 'opportunities.store']);
        Permission::create(['name' => 'opportunities.store.user']);
        Permission::create(['name' => 'opportunities.update']);
        Permission::create(['name' => 'opportunities.delete']);

        Permission::create(['name' => 'categories.all']);
        Permission::create(['name' => 'categories.show']);
        Permission::create(['name' => 'categories.store']);
        Permission::create(['name' => 'categories.update']);
        Permission::create(['name' => 'categories.delete']);
        
        Permission::create(['name' => 'roles.all']);
        Permission::create(['name' => 'roles.store']);
        Permission::create(['name' => 'roles.show']);
        Permission::create(['name' => 'roles.update']);
        Permission::create(['name' => 'roles.delete']);

    }
}




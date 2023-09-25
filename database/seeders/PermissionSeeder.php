<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'user.all']);
        Permission::create(['name' => 'user.show']);
        Permission::create(['name' => 'user.store']);
        Permission::create(['name' => 'user.update']);
        Permission::create(['name' => 'user.delete']);
        Permission::create(['name' => 'product.all']);
        Permission::create(['name' => 'product.show']);
        Permission::create(['name' => 'product.store']);
        Permission::create(['name' => 'product.update']);
        Permission::create(['name' => 'product.delete']);
        Permission::create(['name' => 'order.all']);
        Permission::create(['name' => 'order.show']);
        Permission::create(['name' => 'order.store']);
        Permission::create(['name' => 'order.update']);
        Permission::create(['name' => 'order.delete']);
        Permission::create(['name' => 'facture.all']);
        Permission::create(['name' => 'facture.show']);
        Permission::create(['name' => 'facture.store']);
        Permission::create(['name' => 'facture.update']);
        Permission::create(['name' => 'facture.delete']);
        Permission::create(['name' => 'opportunity.all']);
        Permission::create(['name' => 'opportunity.show']);
        Permission::create(['name' => 'opportunity.store']);
        Permission::create(['name' => 'opportunity.update']);
        Permission::create(['name' => 'opportunity.delete']);

    }
}




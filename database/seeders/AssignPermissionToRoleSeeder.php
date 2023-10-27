<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignPermissionToRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::findByName('admin.users');
        $role1->givePermissionTo('users.*'); 

        $role2 = Role::findByName('admin.products');
        $role2->givePermissionTo('products.*'); 

        $role3 = Role::findByName('admin.orders');
        $role3->givePermissionTo('orders.*'); 

        $role4 = Role::findByName('admin.factures');
        $role4->givePermissionTo('factures.*'); 

        $role5 = Role::findByName('admin.opportunities');
        $role5->givePermissionTo('opportunities.*'); 

        $role6 = Role::findByName('admin.categories');
        $role6->givePermissionTo('categories.*'); 

        $role7 = Role::findByName('admin.roles');
        $role7->givePermissionTo('roles.*'); 

        
        $role8 = Role::findByName('admin');
        $permissions8 = ['users.*' , 'products.*' ,'orders.*' , 'factures.*' ,'opportunities.*' , 'categories.*' , 'roles.*'];
        $role8->givePermissionTo($permissions8);


        $role9 = Role::findByName('seler');
        $permissions9 = ['users.all.user', 'users.update.user' , 'users.delete.user' , 'products.all' , 'products.show' ,
                          'products.store.seler' , 'products.update.seler' , 'products.delete.seler'];
        $role9->givePermissionTo($permissions9);


        $role10 = Role::findByName('customer');
        $permissions10 = ['users.all.user','users.update.user','users.delete.user','products.all','products.show','orders.all.user',
                           'orders.store.user','factures.all.user','opportunities.all.user','opportunities.store.user'];
        $role10->givePermissionTo($permissions10);


        $role11 = Role::findByName('default');
        $permissions11 = ['products.all','products.show' , 'categories.all' , 'categories.show'];
        $role11->givePermissionTo($permissions11);

    }
}

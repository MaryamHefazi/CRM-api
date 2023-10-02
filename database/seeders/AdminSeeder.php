<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name'=> 'selena',
            'email'=> 'selena@gmail.com',
            'password'=>Hash::make('1234'),
        ]);

        #1 : assign permissions to role and create a new user
        $role1 = Role::findById(1);
        $permissions = [1,2,3,4,5,6,7]; 
        $role1->givePermissionTo($permissions);
        $admin->assignRole($role1);

        // #2 : assign permissions to user
        // $permissions = [1,2,3,4,5,6,7];
        // $user->givePermissionTo($permissions);


        $user = User::create([
            'name'=> 'sam',
            'email'=> 'sam@gmail.com',
            'password'=>Hash::make('1234'),
        ]);

        $role2 = Role::findById(8);
        $permissions = ['users.all.user', 'products.all', 'products.show', 'orders.all.user', 'orders.store.user' , 'factures.all.user', 'opportunities.all.user', 'opportunities.store.user' ,'categories.all', 'categories.show']; 
        $role2->givePermissionTo($permissions);
        $user->assignRole($role2);

    }
}


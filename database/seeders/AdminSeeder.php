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

        $admin->assignRole('admin');

        #1 : assign permissions to role and create a new user
        // $role1 = Role::findByName('admin');
        // $permissions = [1,2,3,4,5,6,7]; 
        // $role1->givePermissionTo($permissions);
        // $admin->assignRole($role1);

        // #2 : assign permissions to user
        // $permissions = [1,2,3,4,5,6,7];
        // $user->givePermissionTo($permissions);


        $user = User::create([
            'name'=> 'sam',
            'email'=> 'sam@gmail.com',
            'password'=>Hash::make('1234'),
        ]);

        $user->assignRole('customer');

    }
}


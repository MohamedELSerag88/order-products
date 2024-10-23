<?php

namespace Database\Seeders;



use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => "User",
            'email' => "user@order.com",
            'password' => \Hash::make("123456")
        ]);
        $admin = User::create([
            'name' => "Admin",
            'email' => "admin@order.com",
            'password' => \Hash::make("123456")
        ]);
        $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'create products']);
        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'update products']);
        $role->givePermissionTo('create products');
        $role->givePermissionTo('update products');
        $admin->assignRole('admin');
    }
}

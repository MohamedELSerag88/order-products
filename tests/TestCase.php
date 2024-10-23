<?php

namespace Tests;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function addUser(){
        return User::create([
            'name' => 'user test',
            'email' => 'email@order.com',
            'password' => Hash::make('123456')
        ]);
    }

    public function AddOrder(){
        return Order::create([
            "product_name"=>"test",
            "quantity"=>1,
            "unit_price"=>1,
            "total"=>1,
            "status"=>"Pending",
            "user_id"=>User::first()->id,
        ]);
    }

    public function addPermission()
    {
        $role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $permission = \Spatie\Permission\Models\Permission::create(['name' => 'update orders']);
        $role->givePermissionTo('update orders');
        $user = $this->addUser();
        $user->assignRole('admin');
        return $user;
    }
}

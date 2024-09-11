<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'admin']);
        $vendorRole = Role::create(['name' => 'vendor']);
        $customerRole = Role::create(['name' => 'customer']);
        $viewItemPermission = Permission::create(['name' => 'view items']);
        $createItemPermission = Permission::create(['name' => 'create items']);
        $updateItemPermission = Permission::create(['name' => 'update items']);
        $deleteItemPermission = Permission::create(['name' => 'delete items']);
        $viewCatPermission = Permission::create(['name' => 'view categories']);
        $createCatPermission = Permission::create(['name' => 'create categories']);
        $updateCatPermission = Permission::create(['name' => 'update categories']);
        $deleteCatPermission = Permission::create(['name' => 'delete categories']);
        $addItemToCatPermission = Permission::create(['name' => 'add item to categories']);
        $removeItemFromCatPermission = Permission::create(['name' => 'remove item from categories']);
        $updateItemFromCatPermission = Permission::create(['name' => 'update item of categories']);
        $adminRole->givePermissionTo([
            $viewItemPermission,
            $createItemPermission,
            $updateItemPermission,
            $deleteItemPermission,
            $viewCatPermission,
            $createCatPermission,
            $updateCatPermission,
            $deleteCatPermission,
            $addItemToCatPermission,
            $removeItemFromCatPermission,
            $updateItemFromCatPermission
        ]);
        $vendorRole->givePermissionTo([
           $viewItemPermission,
           $createItemPermission,
           $updateItemPermission,
           $deleteItemPermission,
           $viewCatPermission,
           $addItemToCatPermission,
           $removeItemFromCatPermission,
           $updateItemFromCatPermission
        ]);
    }
}

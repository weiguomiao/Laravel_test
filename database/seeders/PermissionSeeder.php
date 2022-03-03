<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');
        //添加权限
        $permission=[
            ['name'=>'users.index', 'cn_name'=>'用户列表'],
            ['name'=>'users.show', 'cn_name'=>'用户详情'],
            ['name'=>'users.lock', 'cn_name'=>'用户锁定'],

        ];
        foreach ($permission as $p){
            Permission::create($p);
        }
        //添加角色
        $role=Role::create(['name'=>'super_admin', 'cn_name'=>'超级管理员']);
        //为角色添加权限
        $role->givePermissionTo(Permission::all());
    }
}

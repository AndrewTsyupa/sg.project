<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $role_employee = new Role();
        $role_employee->name = Role::ROLE_ADMIN;
        $role_employee->description = 'Admin';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = Role::ROLE_EDITOR;
        $role_manager->description = 'Editor';
        $role_manager->save();

        $role_manager = new Role();
        $role_manager->name = Role::ROLE_USER;
        $role_manager->description = 'user';
        $role_manager->save();
    }
}

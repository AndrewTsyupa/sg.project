<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $role_admin = Role::where('name', Role::ROLE_ADMIN)->first();
        $role_editor = Role::where('name', Role::ROLE_EDITOR)->first();
        $role_user = Role::where('name', Role::ROLE_USER)->first();

        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->name = 'editor1';
        $user->email = 'editor1@usr.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_editor);

        $user = new User();
        $user->name = 'editor2';
        $user->email = 'editor2@usr.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_editor);

        $user = new User();
        $user->name = 'user1';
        $user->email = 'user1@usr.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_user);

        $user = new User();
        $user->name = 'user2';
        $user->email = 'user2@usr.com';
        $user->password = bcrypt('123456');
        $user->save();
        $user->roles()->attach($role_user);
    }

}

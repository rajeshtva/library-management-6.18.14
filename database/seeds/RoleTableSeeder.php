<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create(['name' => 'admin']);
        $student =  Role::create(['name' => 'student']);

        $admin->givePermissionTo(['add_books', 'show_books', 'edit_books', 'delete_books']);
        $student->givePermissionTo(['show_books']);
    }
}

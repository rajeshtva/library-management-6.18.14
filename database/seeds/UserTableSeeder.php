<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 15)->create();

        foreach ($users as $user) {
            if ($user->id == 1) {
                $user->assignRole('admin');
            } else
                $user->assignRole('student');
        }
    }
}

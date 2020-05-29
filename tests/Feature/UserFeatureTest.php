<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Str;


class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aCreatedUserHasRoleOfStudent()
    {
        $this->withoutExceptionHandling();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $data)->assertStatus(302)->assertRedirect('/home');

        // $response->assertSuccessful();
        // $user = User::find($response->id);
        // $users = User::all();
        // dd($users);
        $user = User::find(3);
        // dd($user);
        $this->assertTrue($user->hasRole('Student'));
    }

    /** @test */
    public function a_created_user_should_have_show_books_permission()
    {
        // $this->withoutExceptionHandling();
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post('/register', $data)->assertStatus(302)->assertRedirect('/home');

        // $response->assertSuccessful();
        // $user = User::find($response->id);
        // $users = User::all();
        // dd($users);
        $user = User::find(3);
        // dd($user);
        $this->assertTrue($user->hasPermissionTo('show_books'));   
    }

    
}

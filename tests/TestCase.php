<?php

namespace Tests;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Faker\Factory as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations;

    protected $createBookPermission;
    protected $showBookPermission;
    protected $editBookPermission;
    protected $deleteBookPermission;

    protected $adminRole;
    protected $studentRole;
    protected $student;

    /** 
     * set up the test. 
     */

    public function setUp() : void
    {
        parent::setUp();

        $this->faker = Faker::create();
        $this->admin = factory(User::class)->create();
        $this->student = factory(User::class)->create();

        $this->createBookPermission = Permission::create(['name' => 'add_books']);
        $this->showBookPermission = Permission::create(['name' => 'show_books']);
        $this->editBookPermission = Permission::create(['name' => 'edit_books']);
        $this->deleteBookPermission = Permission::create(['name' => 'delete_books']);
        
        Role::create(['name' => 'Admin']);
        $this->adminRole = Role::find(1);

        Role::create(['name' => 'Student']);
        $this->studentRole = Role::find(2);


        $this->adminRole->givePermissionTo(['add_books', 'show_books', 'edit_books', 'delete_books']);
        $this->studentRole->givePermissionTo(['show_books']);

        $this->admin->assignRole('Admin');
        $this->student->assignRole('Student');
    }

    public function tearDown() : void
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}

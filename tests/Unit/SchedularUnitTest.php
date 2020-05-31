<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class SchedularUnitTest extends TestCase
{

    /** @test */
    public function testingToRunScheduledTask()
    {
        dump('running scheduled task');
        $this->assertTrue(true);
    }

    protected function storeBooks()
    {
        for ($i = 0; $i < 20; $i++) {
            $data = [
                'book_name' => $this->faker->realText($maxNbChars = 30, $indexSize = 4),
                'author_name' => $this->faker->name,
                'description' => $this->faker->paragraph($nbSentence = 10, $variableNbSentence = true),
                'price' => $this->faker->randomFloat(3, 0, 1000)
            ];

            $this->actingAs($this->admin)->post(route('books.store'), $data);
        }
    }

    protected function storeUser()
    {
        for ($i=0; $i < 4; $i++) { 

            $data = [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'password' => 'password',
                'password_confirmation' => 'password',
            ];
    
            $response = $this->post('/register', $data);
        }
    }

    
}

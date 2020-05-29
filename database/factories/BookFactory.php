<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'book_name' => $this->faker->realText($maxNbChars = 30, $indexSize= 4),
        'author_name' => $this->faker->name,
        'description' => $this->faker->paragraph($nbSentence = 10, $variableNbSentence = true),
        'price' => $this->faker->randomFloat(3, 0, 1000)
    ];
});

<?php

use App\Book;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 20; $i++) { 
        $book = factory(Book::class)->make(['user_id' => 1]);
            DB::table('books')->insert([
                'book_name' => $book->book_name,
                'description' => $book->description,
                'price' => $book->price,
                'author_name' => $book->author_name,
                'user_id' => $book->user_id,
            ]);
        }
    }
}

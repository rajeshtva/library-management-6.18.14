<?php

use App\Book;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $books_count = Book::count();

        foreach($users as $user)
        {   
            $randsubscription = rand(1, 10);

            for ($i=0; $i < $randsubscription; $i++) { 
                $rand_index = rand(1, $books_count);
                $book = Book::findOrFail($rand_index);

                DB::table('book_user')->insert([
                    'user_id' => $user->id,
                    'book_id' => $rand_index,
                    'current_charge' => $book->price,
                    'past_charges' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => null, 
                    'deleted_at' => null,
                ]);
            }
        }
    }
}

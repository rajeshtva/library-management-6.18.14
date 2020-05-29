<?php

class ABC
{
    public function checkOut()
    {
        $cart = session()->get('cart');
        $user = auth()->user();

        foreach ($cart as $cart_item) {
            // dump($cart_item);
            $book = Book::find($cart_item);
            $d = 0;
            $allData = [];

            dump($book->price);

            if ($book == null) {
                return redirect('/home')->with('message', "BOOK DOESN'T EXIST");
            }

            $book_exist_in_database = DB::table('book_user')->where([
                ['user_id', '=', $user->id],
                ['book_id', '=', $book->id],
            ])->exists();
            // dump($book_exist_in_database);


            if ($book_exist_in_database === true) {
                dump('inside book_exist_in_database');
                $actual_book = $user->hasRented->find($book->id)->pivot;

                dump($actual_book->past_charges);
                dump($actual_book->current_charge);

                $past_charge = $actual_book->past_charges;
                $current_charge = $actual_book->current_charge;
                $sum = $past_charge + $current_charge;
                dump($sum);

                $data = [
                    'past_charges' => $sum,
                    'current_charge' => $current_charge,
                ];

                dump($data);

                $allData[$book->id] = $data;
            } else {
                dump('outside book_exist');
                $data = [
                    'past_charges' => $d,
                    'current_charge' => $book->price,
                ];

                $allData[$book->id] = $data;
            }

            $user->hasRented()->syncWithoutDetaching($allData);
        }
        // dump($allData);
        // syncing the data to the database
        return redirect('/home');
    }
}

<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $cart = session()->get('cart');
        if (empty($cart)) {
            $cart = array();
            session()->put('cart', $cart);
        }
    }

    /**
     * Add books to the cart
     */
    public function store()
    {
        $id = request()->input('book_id');
        $book = Book::findOrFail($id);
        $message = '';
        if (isset($book)) {
            $cart = session()->get('cart');
            if (!in_array($id, $cart)) {
                session()->push('cart', $id);
                $message = 'Book Added To the cart successfully';
            } else {
                $message = 'This Book already exists';
            }
        } else {
            $message = 'Book Not Found';
        }
        return redirect('/home')->with('message', $message);
    }

    /**
     * View the cart
     */
    public function index()
    {
        $cart = session()->get('cart');
        $books = array();
        foreach ($cart as $item) {
            $book = Book::findOrFail($item);
            array_push($books, $book);
        }
        return view('students.cart', compact('books'));
    }

    /**
     * remove book from cart 
     */
    public function destroy()
    {
        $id = request()->input('book_id');
        $cart = session()->get('cart');
        $key = array_search($id, $cart);
        if ($key !== false) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);
        return redirect('/home')->with('message', 'Book Removed!');
    }

    public function checkOut()
    {
        $cart = session()->get('cart');
        $user = auth()->user();

        foreach ($cart as $cart_item) {
            // dump($cart_item);
            $book = Book::find($cart_item);
            $d = 0;
            $allData = [];

            // dump($book->price);

            if ($book == null) {
                return redirect('/home')->with('message', "BOOK DOESN'T EXIST");
            }

            $book_exist_in_database = DB::table('book_user')->where([
                ['user_id', '=', $user->id],
                ['book_id', '=', $book->id],
            ])->exists();
            // dump($book_exist_in_database);


            if ($book_exist_in_database === true) {
                // dump('inside book_exist_in_database');
                $actual_book = $user->hasRented->find($book->id)->pivot;

                // dump($actual_book->past_charges);
                // dump($actual_book->current_charge);

                $past_charge = $actual_book->past_charges;
                $current_charge = $actual_book->current_charge;
                $sum = $past_charge + $current_charge;
                // dump($sum);

                $data = [
                    'past_charges' => $sum,
                    'current_charge' => $current_charge,
                ];

                $actual_book->past_charges = $sum;
                $actual_book->updated_at = now();
                $actual_book->save();

                // dump($data);

                $allData[$book->id] = $data;
            } else {
                // dump('outside book_exist');
                $data = [
                    'past_charges' => $d,
                    'current_charge' => $book->price,
                ];

                $allData[$book->id] = $data;
                $user->hasRented()->syncWithoutDetaching($allData);
            }

        }
        // dump($allData);
        // syncing the data to the database
        return redirect('/home');
    }

    public function softDeleteBooksFrom()
    {
        
    }
}

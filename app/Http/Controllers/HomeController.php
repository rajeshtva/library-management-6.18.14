<?php

namespace App\Http\Controllers;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $cart = session()->get('cart');
        if (empty($cart)) {
            $cart = array();
            session()->put('cart', $cart);
            // dump($cart);
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $books = Book::take(20)->get();
        $count = Book::count();

        $id = auth()->user()->id;

        $books_added_to_cart = DB::table('book_user')->where('user_id', $id)->get();
        $books_added_to_cart = json_decode(json_encode($books_added_to_cart), true);

        $already_subs = array();
        foreach($books_added_to_cart as $book){
            array_push($already_subs, $book['book_id']);
        }
        return view('home', compact('books', 'count', 'already_subs'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('isAdmin')->except(['show', 'index']);
        // $this->middleware('showBooks')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $books = Book::all();
        return view('admin.books.index', [
            'books' => $books,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'book_name' => 'required|string',
            'author_name' => 'required|string',
            'description' => 'required',
            'price' => 'numeric|min:0'
        ]);

        // $data = array_merge($data, [
        //     'added_by' => auth()->user()->id,
        // ]); 
        $data['price'] = (float)$data['price'];

        auth()->user()->books()->create($data);
        return redirect('/books');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
       $data =  $this->validate($request,  [
            'book_name' => 'required|string',
            'author_name' => 'required|string',
            'description' => 'required',
            'price' => 'numeric|min:0'
        ] );
    

        $book->update($data);
        return redirect(route('books.edit', $book->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return "destroy bookscontroller";
        //
    }

    public function getSubscription(User $user)
    {
        $books = $user->hasRented->where('deleted_at', '!=', null);
        return view('admin.books.subscription', compact('books'));
    }
}

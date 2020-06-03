<?php

namespace App\Http\Controllers;

use App\Book;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function __construct()
    {
        $this->middleware('isAdmin')->except(['show', 'index', 'unsubscribe']);
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

        foreach($books as $book)
        {
            $book->description = substr($book->description, 0, 80).'...';
            $book->rented_by = DB::table('book_user')->where('book_id', $book->id)->count();
        }
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
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect(route('books.index'));
        //
    }

    public function getSubscription(User $user)
    {
        $books = $user->hasRented->where('deleted_at', '!=', null);
        return view('admin.books.subscription', compact('books'));
    }

    public function forceDelete($id)
    {
        $book = Book::withTrashed()->find($id);
        $book->forceDelete();
        return redirect(route('books.index'));
    }

    public function restore($id)
    {
        $book = Book::withTrashed()->find($id);
        $book->restore();
        return redirect(route('books.index'));
    }
 
    public function forceDeletePage()
    {
        $books = Book::onlyTrashed()->get();
        // dump($books);


        return view('admin.books.forceDeletePage', compact('books'));
    }

    public function unsubscribe()
    {
        $book_id = request()->input('book_id');
        // dd($book_id);
        // $delete = [ 'updated_at' => Carbon::now() ];


        DB::table('book_user')->where([
            ['user_id', '=', auth()->user()->id],
            ['book_id', '=', $book_id]
        ])->delete();
        return redirect('/home');
    }



}

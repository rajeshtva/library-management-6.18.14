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

        foreach ($books as $book) {
            $book->description = substr($book->description, 0, 80) . '...';
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
        $data = $this->validateRequest();

        $data['image'] = request()->image->store('images', 'public');

        $data['file'] = request()->file->store('books', 'public');
        
        // $data = array_merge($data, [
        //     'added_by' => auth()->user()->id,
        // ]); 
        $data['price'] = (float) $data['price'];

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
     * @param  int  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $data =  $this->validateRequest();
        $book->update([
            'book_name' => $data['book_name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'author_name' => $data['author_name'],
        ]);

        $this->storeFile($book);
        $this->storeImage($book);
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
        return redirect('/books/trashed');
    }

    public function forceDeletePage()
    {
        $books = Book::onlyTrashed()->get();
        // dd($books);
        foreach ($books as $book) {
            $book->subscribers = DB::table('book_user')->where('book_id', $book->id)->count();
            $book->total_charge = DB::table('book_user')->where('book_id', $book->id)->sum('past_charges');
        }


        return view('admin.books.forceDeletePage', compact('books'));
    }

    public function unsubscribe()
    {
        $book_id = request()->input('book_id');

        DB::table('book_user')->where([
            ['user_id', '=', auth()->user()->id],
            ['book_id', '=', $book_id]
        ])->delete();
        return redirect('/home');
    }

    private function validateRequest()
    {
        return tap(
            request()->validate([
                'book_name' => 'required|string',
                'author_name' => 'required|string',
                'description' => 'required',
                'price' => 'numeric|min:0',
                'file'=> 'file|mimes:pdf'
            ]),
            function () {
                if (request()->hasFile('image')) {
                    request()->validate([
                        'image' => 'file|image|max:5000|mimes:jpg,jpeg,bmp,png',
                    ]);
                }
            }
        );
    }

    private function storeImage($book)
    {
        if (request()->has('image')) {
            $book->update([
                'image' => request()->image->store('images', 'public'),
            ]);
        }

        return $book;
    }

    private function storeFile($book)
    {
        if (request()->has('file')) {
            $book->update([
                'file' => request()->file->store('books', 'public')
            ]);
        }

        return $book;
    }
}

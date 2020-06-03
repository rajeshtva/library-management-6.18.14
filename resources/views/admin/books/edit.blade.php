@extends('admin.layouts.app')


@section('admin-content')

<div>
    @section('name') Edit {{ $book->book_name }} @endsection

    <a href="/books"> <button class="btn btn-primary mb-3">Go to index page</button></a>

    <form action="{{ route('books.update', $book->id )}}" class="was-validated" method="POST">
        @csrf
        @method("PATCH")

        <label for="book_name"> <b>Book Name:</b>
        </label>
        <input type="text" name="book_name" value="{{ old('book_name') ?? $book->book_name }}" class="form-control">

        <label for="author_name"> <b>Author Name</b> </label>
        <input type="text" name="author_name" value="{{ old('author_name') ?? $book->author_name }}" class="form-control">


        <div class="mb-3">
            <label for="description">Description</label>
            <textarea class="form-control is-invalid" name="description" id="description" cols="30" rows="10" required> {{ old('description') ?? $book->description }} </textarea>
            <div class="invalid-feedback">
                Please enter a message in the textarea.
            </div>
        </div>

        <label for="price">Price</label>
        <input type="number" step="0.001" name="price" value="{{ old('price') ?? $book->price }}" class="form-control">

        <input type="submit" value="submit" class="btn btn-primary mt-3">
    </form>
</div>

@endsection